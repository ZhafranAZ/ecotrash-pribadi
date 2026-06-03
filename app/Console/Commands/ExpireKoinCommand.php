<?php

namespace App\Console\Commands;

use App\Services\CoinService;
use Illuminate\Console\Command;

class ExpireKoinCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'koin:expire';

    /**
     * The console command description.
     */
    protected $description = 'Memproses koin yang sudah melewati masa berlaku 6 bulan (expired)';

    /**
     * Execute the console command.
     */
    public function handle(CoinService $coinService): int
    {
        $this->info('Memulai proses expire koin...');

        try {
            $totalProcessed = $coinService->expireCoins();

            $this->info("Berhasil memproses {$totalProcessed} record koin expired.");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Gagal memproses expire koin: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}
