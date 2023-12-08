<?php



namespace Solenoid\Log;



use \Solenoid\System\File;



class Logger
{
    private File $file;



    # Returns [self]
    public function __construct (string $file_path)
    {
        // (Getting the values)
        $this->file = File::select( $file_path );
    }

    # Returns [Logger]
    public static function create (string $file_path)
    {
        // Returning the value
        return new Logger( $file_path );
    }



    # Returns [string]
    public static function format_row (string $message)
    {
        // (Getting the value)
        $message = str_replace( [ "\r\n", "\n\r", "\n", "\r" ], ' >> ', $message );



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
        return $this->file->write( self::format_row( $message ) . "\n", 'append' ) !== false;
    }



    # Returns [array<string>]
    public function list (string $eol = PHP_EOL, ?string $regex = null)
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
            $eol,
            $regex
        )
        ;



        // Returning the value
        return $list;
    }
}



?>