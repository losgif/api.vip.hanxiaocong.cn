<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class SetSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:set {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将用户提升为超级管理员';

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
        try {
            $id = $this->argument('id');

            $user = User::where('id', $id)->first();

            if (empty($user)) {
                throw new \Exception('用户不存在');
            }
            
            $user->assignRole('super-admin');

            $this->info("权限提升成功");
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
    }
}
