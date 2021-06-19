<?php


class application
{
    public array $correctTypes = ["regular holiday", "vacation on request", "unpaid leave"];
    private string $type;
    private DateTime $dateFrom;
    private DateTime $dateTo;
    private string $file;
    private string $comment;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @throws Exception
     */
    public function setType(string $type): void
    {
        if (!in_array($type, $this->correctTypes)) throw new Exception("Incorrect leave type");
        $this->type = $type;
    }

    /**
     * @return DateTime
     */
    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    /**
     * @param string $dateFrom
     * @throws Exception
     */
    public function setDateFrom(string $dateFrom): void
    {
        if (strcmp(trim($dateFrom), "") == 0) throw new Exception("Data mustn't be empty");
        $tmp = DateTime::createFromFormat("Y-m-d", $dateFrom);
        if (new DateTime("now") > $tmp) throw new Exception("Incorrect date. You cannot take holiday in the past");
        $this->dateFrom = $tmp;
    }

    /**
     * @return DateTime
     */
    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }

    /**
     * @param string $dateTo
     * @throws Exception
     */
    public function setDateTo(string $dateTo): void
    {
        if (strcmp(trim($dateTo), "") == 0) throw new Exception("Data mustn't be empty");
        $tmp = DateTime::createFromFormat("Y-m-d", $dateTo);
        if (new DateTime("now") > $tmp) throw new Exception("Incorrect date. You cannot take holiday in the past");
        $this->dateTo = $tmp;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $documentName
     */
    public function setFile(string $documentName)
    {
        $this->file = $documentName;
    }

    /**
     * @param string $login
     * @return bool
     * @throws Exception
     */
    public function proceed(string $login): bool
    {
        try {
            require_once __DIR__ . "./../dbConnect.php";
            global $db;

            $query = $db->prepare("INSERT INTO holidays (user, type, dateFrom, dateTo, file, comment) VALUES (:user, :type, :dateFrom, :dateTo, :file, :comment)");

            $query->bindValue(":user", $login, PDO::PARAM_STR);
            $query->bindValue(":type", $this->type, PDO::PARAM_STR);
            $query->bindValue(":dateFrom", $this->dateFrom->format("Y-m-d"), PDO::PARAM_STR);
            $query->bindValue(":dateTo", $this->dateTo->format("Y-m-d"), PDO::PARAM_STR);
            $query->bindValue(":file", $this->file, PDO::PARAM_STR);
            $query->bindValue(":comment", $this->comment, PDO::PARAM_STR);

            $query->execute();

        } catch (PDOException $e) {

            throw new Exception("User with the same login exist. Unable to create account.");
        }


        return true;
    }

    /**
     * @throws Exception
     */
    public function checkDates()
    {
        if (isset($this->dateFrom) && isset($this->dateTo)) {
            if($this->dateFrom > $this->dateTo) {
                throw new Exception("Dates are incorrect. You cannot travel in time.");
            }
        }

    }

    /**
     * @return int
     */
    public function workingDays() : int
    {
        $workingDays = 0;
        $tmpDate = clone $this->dateFrom;

        while($tmpDate < $this->dateTo) {
            $tmpDate->add(new DateInterval("P1D"));
            if($tmpDate->format("N")!=7 && $tmpDate->format("N") != 6) $workingDays++;
        }
        return $workingDays;
    }

}