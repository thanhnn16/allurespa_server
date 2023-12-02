<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        return view('pages.dashboard');
    }

    public function home()
    {
        return redirect('/dashboard');
    }

    public function webhook(Request $request)
    {
        if ($request->hasHeader('X-GitHub-Event')) {
            if ($request->header('X-GitHub-Event') == 'pull_request') {
                $payload = $request->all();
                if ($payload['action'] == 'closed') {
                    try {
                        $this->gitPull();
                    } catch (Exception $e) {
                        return response()->json(['error' => $e->getMessage()]);
                    }
                }
            }
        }
        return response()->json(['success' => 'Webhook received']);
    }

    /**
     * @throws Exception
     */
    private function gitPull()
    {
        $process = new Process(['cd /var/www/allurespa_server && git pull']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new Exception('Git pull failed: ' . $process->getErrorOutput());
        }

        echo $process->getOutput();
    }
}
