<?php

declare(strict_types=1);

require './constants.php';

/**
 * Formatea la fecha de `$data` para mostrarla correctamente en el formato `M j, Y`
 */
function format_date(String $date): String
{
  return date('M j, Y', strtotime($date));
}

/**
 * Formatea el monto de `$value` para mostrarlo correctamente en un formato de moneda 
 * 
 * @param Int|Float $value Valor a transformar
 */
function format_amount(Int|Float $value): String
{
  $char = '$';
  $is_negative = $value < 0;

  return ($is_negative ? '-' : '') . $char . number_format(abs($value), 2);
}

/**
 * Busca en el directorio `views` la plantilla con el nombre `$template_name`, si existe, devuelve su contenido.
 * 
 * @param String $template_name Nombre de la plantilla 
 */
function get_template(String $template_name): Void
{
  $path = VIEWS_DIR . "/$template_name.php";

  include $path;
}

/**
 * Lee los archivos csv pasados y extrae la información de las transacciones
 * 
 * @param Array $files Archivos csv con información de las transacciones
 */
function get_transactions(array $files): array
{
  $result = [];

  foreach ($files as $file) {
    $current_file = fopen($file, 'r');

    // Omite la primera línea
    fgetcsv($current_file);

    while (($line = fgetcsv($current_file)) !== false) {
      $transaction = get_transaction_data($line);
      $result[] = $transaction;
    }

    fclose($current_file);
  }

  return $result;
}

/**
 * Extrae la información de la transferencia del array `$transaction`
 * 
 * @param Array $transaction Array de la transferencia generado con `fgetcsv` 
 */
function get_transaction_data(array $transaction): array
{
  [$date, $check_number, $description, $amount] = $transaction;

  $amount = (float) str_replace(['$', ','], '', $amount);

  return [
    'date'         => $date,
    'check_number' => $check_number,
    'description'  => $description,
    'amount'       => $amount
  ];
}

/**
 * Obtiene el total de ingresos y gastos de las transacciones 
 * 
 * @param Array $transactions Transacciones a procesar
 */
function get_totals(array $transactions): array
{
  $totals = ['income' => 0, 'expense' => 0, 'total' => 0];

  foreach ($transactions as $transaction) {
    $amount = $transaction['amount'];

    $totals['total'] += $amount;

    if ($amount >= 0) {
      $totals['income'] += $amount;
    } else {
      $totals['expense'] += $amount;
    }
  }

  return $totals;
}
