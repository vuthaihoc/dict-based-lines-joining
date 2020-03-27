<?php
/**
 * Created by PhpStorm.
 * User: hocvt
 * Date: 2020-03-27
 * Time: 15:35
 */

namespace HocVT\PdfToText;


use Symfony\Component\Process\Process;

class Converter {
    
    protected $bin = "pdftotext";
    protected $options = [
//        "-raw",
        "-f","3",
        "-l","3",
        "-q",
    ];
    protected $process;
    
    /**
     * Converter constructor.
     */
    public function __construct() {
    }
    
    public function run( $path, $page = 1 ) {
        $command = array_merge(
            [ $this->bin ],
            $this->options,
            [ $path, "-" ]
        );
        $process = new Process( $command );
        $process->run();
        $this->validateRun( $process );
        
        return $process->getOutput();
        
    }
    
    
    protected function validateRun( Process $process ) {
        $status = $process->getExitCode();
        $error = $process->getErrorOutput();
        
        if ( $status !== 0 and $error !== '' ) {
            throw new \RuntimeException(
                sprintf(
                    "The exit status code %s says something went wrong:\n stderr: %s\n stdout: %s\ncommand: %s.",
                    $status,
                    $error,
                    $process->getOutput(),
                    $process->getCommandLine()
                )
            );
        }
    }
    
}