<?php

function uploadFile(): string
{
    $max_size = 10 * 1024 * 1024 + 1023;
    $directory = "upload";
    $return = "./holiday.php";

    $errors = [
        "no_file" => "File not found",
        "type" => "Incorrect type (.pdf or .jpg)",
        "ext" => "Incorrect extension (.pdf or .jpg)",
        "max_size" => "File is too big (max size: {$max_size})",
        "unknown" => "Unknown problem",
        "internal" => "Internal error"
    ];

    $extensions = ["pdf", "jpg"];
    $types = ["application/pdf", "image/jpg", "image/JPG", "image/jpeg"];

    if (isset($_SESSION["error"])) unset($_SESSION["error"]);
    if (!isset($_FILES['document'])) {
        header("Location: {$return}");
        exit();
    }


    $document = $_FILES['document'];

    try {
        //nie załadowano pliku
        if ($document["error"] == UPLOAD_ERR_NO_FILE) {
            throw new Exception($errors["no_file"]);
        }

        //inny błąd
        if ($document["error"] != UPLOAD_ERR_OK) {
            throw new Exception($errors["unknown"]);
        }

        //nie poprawny typ MIME
        if (!in_array($document["type"], $types)) {
            throw new Exception($errors["type"]);
        }

        //nie poprawne rozszerzenie
        $tmp = explode(".", $document["name"]);
        $extension = end($tmp);
        unset($tmp);
        if (!in_array($extension, $extensions)) {
            throw new Exception($errors["ext"]);
        }

        //plik ma za duży rozmiar
        if ($document["size"] > $max_size) {
            throw new Exception($errors["max_size"]);
        }

        //plik wydaje się być poprawny
        //wygenerujmy mu nową nazwę
        $newName = (new DateTime())->format("Y-m-d_H_i_s")
            . "_"
            . substr(strval(uniqid()), 8, 13)
            . "."
            . $extension;

        if (file_exists($directory) && is_dir($directory)) {
            //wstaw do folderu
            if (move_uploaded_file($document["tmp_name"], "./{$directory}/{$newName}")) {
                echo "file uploaded";

                return "./{$directory}/{$newName}";
            } else {
                throw new Exception($errors["internal"]);
            }
        } else {
            throw new Exception($errors["internal"]);
        }

    } catch (Exception $e) {
        $_SESSION["upload_error"] = $e->getMessage();
        header("Location: {$return}");
        exit();
    }
}
