<?php
use Carbon\Carbon;

if (!function_exists('rupiah')) {
    function rupiah($angka)
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}
function formatBulanTahun($timestamp)
{
    if (!$timestamp) return null;

    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    $date = new DateTime($timestamp);

    $namaBulan = $bulan[(int) $date->format('n')];
    $tahun = $date->format('Y');

    return "$namaBulan $tahun";
}


function formatTanggalIndonesia($timestamp)
{
    return Carbon::parse($timestamp)
        ->locale('id')
        ->translatedFormat('d F Y');
}
