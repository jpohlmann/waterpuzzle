<?php
class SavedValues
{
    /**
     * Reads the saved solutions from the file
     *
     * @return stdClass Solution object
     */
    public static function readFromFile()
    {
        $jsonResult = file_get_contents('../data/solutions.json');
        $solutions  = json_decode($jsonResult);
        return $solutions;
    }

    /**
     * Writes the saved solutions to a file
     *
     * @param stdClass $solutions Solutions list
     */
    public static function writeToFile($solutions)
    {
        $file = fopen('../data/solutions.json', 'w');
        fwrite($file, json_encode($solutions));
        fclose($file);
    }
}