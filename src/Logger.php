<?php



namespace Solenoid\Log;



use \Solenoid\System\File;



class Logger
{
    public File   $file;
    public string $eol;



    # Returns [self]
    public function __construct (string $file_path, string $eol = "\n")
    {
        // (Getting the values)
        $this->file = File::select( $file_path );
        $this->eol  = $eol;
    }



    # Returns [string]
    public function format_row (string $message)
    {
        // (Getting the value)
        $message = str_replace( [ $this->eol, "\r\n", "\n\r", "\n", "\r" ], '\\n', $message );



        // Returning the value
        return date( '[c]' ) . " :: $message" ;
    }



    # Returns [bool]
    public function reset ()
    {
        // Returning the value
        return $this->file->write() !== false;
    }

    # Returns [bool] | Throws [Exception]
    public function push (string $message)
    {
        // Returning the value
        return $this->file->write( $this->format_row($message) . $this->eol, 'append' ) !== false;
    }



    # Returns [array<string>]
    public function list (?string $regex = null)
    {
        // (Setting the value)
        $list = [];

        // (Walking the lines)
        $this->file->walk
        (
            function ($line) use (&$list)
            {
                // (Appending the value)
                $list[] = $line;
            },
            $this->eol,
            $regex
        )
        ;



        // Returning the value
        return $list;
    }
}



?>