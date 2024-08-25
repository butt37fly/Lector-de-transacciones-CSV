<?php

declare(strict_types=1);

$data = [];
$csv_files = [];

if (! file_exists(UPLOADS_DIR)) {
  mkdir(ROOT_DIR . 'uploads');

  $data['msg'] = 'No se han encontrado archivos';
  return;
}

$dir_files = scandir(UPLOADS_DIR);

foreach ($dir_files as $file) {

  if (! is_dir($file)) {
    $file = UPLOADS_DIR . '/' . $file;

    if (mime_content_type($file) === "text/csv") {
      $csv_files[] = $file;
    }
  }
}

if (empty($csv_files)) {
  $data['msg'] = 'No se han encontrado archivos';
  return;
}

$transactions = get_transactions($csv_files);
$totals = get_totals($transactions);

$data = [
  'transactions' => $transactions,
  'totals'       => $totals
];
