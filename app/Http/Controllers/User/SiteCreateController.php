<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use \Pusher\Pusher;

class SiteCreateController extends Controller
{

    public function createSite(){

        $process = Process::fromShellCommandline(' sh ./sitesetup.sh');
        $process->run();        
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        
        echo $process->getOutput();
    }
}