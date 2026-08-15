<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            // INTERNET
            ['code' => 'INT-10', 'label' => 'Internet 10 Mbps', 'type' => 'internet', 'speed' => 10, 'monthly' => 100, 'installation' => 50, 'active' => true, 'legacy' => false],
            ['code' => 'INT-20', 'label' => 'Internet 20 Mbps', 'type' => 'internet', 'speed' => 20, 'monthly' => 150, 'installation' => 50, 'active' => true, 'legacy' => false],
            ['code' => 'INT-30', 'label' => 'Internet 30 Mbps', 'type' => 'internet', 'speed' => 30, 'monthly' => 200, 'installation' => 50, 'active' => true, 'legacy' => false],
            ['code' => 'INT-50', 'label' => 'Internet 50 Mbps', 'type' => 'internet', 'speed' => 50, 'monthly' => 250, 'installation' => 50, 'active' => true, 'legacy' => false],
            ['code' => 'INT-100', 'label' => 'Internet 100 Mbps', 'type' => 'internet', 'speed' => 100, 'monthly' => 350, 'installation' => 50, 'active' => true, 'legacy' => false],
            ['code' => 'INT-200', 'label' => 'Internet 200 Mbps', 'type' => 'internet', 'speed' => 200, 'monthly' => 450, 'installation' => 50, 'active' => true, 'legacy' => false],

            // TV
            ['code' => 'TV-30', 'label' => 'TV Basico 30 Canales', 'type' => 'tv', 'speed' => null, 'monthly' => 80, 'installation' => 30, 'active' => true, 'legacy' => false],
            ['code' => 'TV-60', 'label' => 'TV Standard 60 Canales', 'type' => 'tv', 'speed' => null, 'monthly' => 120, 'installation' => 30, 'active' => true, 'legacy' => false],
            ['code' => 'TV-90', 'label' => 'TV Premium 90 Canales', 'type' => 'tv', 'speed' => null, 'monthly' => 180, 'installation' => 30, 'active' => true, 'legacy' => false],

            // COMBO
            ['code' => 'COM-10-30', 'label' => 'Combo Internet 10 + TV 30', 'type' => 'combo', 'speed' => 10, 'monthly' => 160, 'installation' => 70, 'active' => true, 'legacy' => false],
            ['code' => 'COM-20-30', 'label' => 'Combo Internet 20 + TV 30', 'type' => 'combo', 'speed' => 20, 'monthly' => 210, 'installation' => 70, 'active' => true, 'legacy' => false],
            ['code' => 'COM-20-60', 'label' => 'Combo Internet 20 + TV 60', 'type' => 'combo', 'speed' => 20, 'monthly' => 250, 'installation' => 70, 'active' => true, 'legacy' => false],
            ['code' => 'COM-30-60', 'label' => 'Combo Internet 30 + TV 60', 'type' => 'combo', 'speed' => 30, 'monthly' => 300, 'installation' => 70, 'active' => true, 'legacy' => false],
            ['code' => 'COM-30-90', 'label' => 'Combo Internet 30 + TV 90', 'type' => 'combo', 'speed' => 30, 'monthly' => 360, 'installation' => 70, 'active' => true, 'legacy' => false],
            ['code' => 'COM-50-60', 'label' => 'Combo Internet 50 + TV 60', 'type' => 'combo', 'speed' => 50, 'monthly' => 350, 'installation' => 70, 'active' => true, 'legacy' => false],
            ['code' => 'COM-50-90', 'label' => 'Combo Internet 50 + TV 90', 'type' => 'combo', 'speed' => 50, 'monthly' => 410, 'installation' => 70, 'active' => true, 'legacy' => false],
            ['code' => 'COM-100-90', 'label' => 'Combo Internet 100 + TV 90', 'type' => 'combo', 'speed' => 100, 'monthly' => 510, 'installation' => 70, 'active' => true, 'legacy' => false],

            // LEGACY (solo retiros)
            ['code' => 'LEG-INT-5', 'label' => 'Internet Legacy 5 Mbps', 'type' => 'internet', 'speed' => 5, 'monthly' => 60, 'installation' => 0, 'active' => true, 'legacy' => true],
            ['code' => 'LEG-INT-10', 'label' => 'Internet Legacy 10 Mbps', 'type' => 'internet', 'speed' => 10, 'monthly' => 80, 'installation' => 0, 'active' => true, 'legacy' => true],
            ['code' => 'LEG-TV-20', 'label' => 'TV Legacy 20 Canales', 'type' => 'tv', 'speed' => null, 'monthly' => 50, 'installation' => 0, 'active' => true, 'legacy' => true],
            ['code' => 'LEG-COM-5-20', 'label' => 'Combo Legacy Internet 5 + TV 20', 'type' => 'combo', 'speed' => 5, 'monthly' => 100, 'installation' => 0, 'active' => true, 'legacy' => true],

            // Additional plans
            ['code' => 'INT-15', 'label' => 'Internet 15 Mbps', 'type' => 'internet', 'speed' => 15, 'monthly' => 120, 'installation' => 50, 'active' => true, 'legacy' => false],
            ['code' => 'INT-25', 'label' => 'Internet 25 Mbps', 'type' => 'internet', 'speed' => 25, 'monthly' => 170, 'installation' => 50, 'active' => true, 'legacy' => false],
            ['code' => 'INT-40', 'label' => 'Internet 40 Mbps', 'type' => 'internet', 'speed' => 40, 'monthly' => 220, 'installation' => 50, 'active' => true, 'legacy' => false],
            ['code' => 'INT-75', 'label' => 'Internet 75 Mbps', 'type' => 'internet', 'speed' => 75, 'monthly' => 300, 'installation' => 50, 'active' => true, 'legacy' => false],
            ['code' => 'INT-150', 'label' => 'Internet 150 Mbps', 'type' => 'internet', 'speed' => 150, 'monthly' => 400, 'installation' => 50, 'active' => true, 'legacy' => false],
            ['code' => 'TV-45', 'label' => 'TV Intermedio 45 Canales', 'type' => 'tv', 'speed' => null, 'monthly' => 100, 'installation' => 30, 'active' => true, 'legacy' => false],
            ['code' => 'TV-75', 'label' => 'TV Gold 75 Canales', 'type' => 'tv', 'speed' => null, 'monthly' => 150, 'installation' => 30, 'active' => true, 'legacy' => false],
            ['code' => 'COM-15-30', 'label' => 'Combo Internet 15 + TV 30', 'type' => 'combo', 'speed' => 15, 'monthly' => 180, 'installation' => 70, 'active' => true, 'legacy' => false],
            ['code' => 'COM-25-60', 'label' => 'Combo Internet 25 + TV 60', 'type' => 'combo', 'speed' => 25, 'monthly' => 270, 'installation' => 70, 'active' => true, 'legacy' => false],
            ['code' => 'COM-40-60', 'label' => 'Combo Internet 40 + TV 60', 'type' => 'combo', 'speed' => 40, 'monthly' => 320, 'installation' => 70, 'active' => true, 'legacy' => false],
            ['code' => 'COM-75-90', 'label' => 'Combo Internet 75 + TV 90', 'type' => 'combo', 'speed' => 75, 'monthly' => 460, 'installation' => 70, 'active' => true, 'legacy' => false],
            ['code' => 'COM-100-60', 'label' => 'Combo Internet 100 + TV 60', 'type' => 'combo', 'speed' => 100, 'monthly' => 450, 'installation' => 70, 'active' => true, 'legacy' => false],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['code' => $plan['code']], $plan);
        }
    }
}
