<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GitHook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'githook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'githook';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dir = storage_path('git') . '/git.log';
        $lock_dir = storage_path('git') . '/git.lock';

        if (file_exists($dir) && !file_exists($lock_dir)) {

            file_put_contents($lock_dir,'');
            chmod($dir, 0777);

            //git 更新
            system("cd /data/youyudoc && git pull");
            //构建gitbook
            system("cd /data/youyudoc && gitbook install");
            system("cd /data/youyudoc && gitbook build");

            //删除lock文件
            unlink($lock_dir);
            //删除lock文件
            unlink($dir);
        }
    }
}
