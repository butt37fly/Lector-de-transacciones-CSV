<?php require 'app/csv_reader.php' ?>

<section class="c-transactions o-container">

  <?php

  if (isset($data['msg'])): ?>

    <h2 class="o-subtitle"> <?= $data['msg'] ?> </h2>

  <?php else: ?>

    <table class="o-table">
      <thead class="o-table__section o-table__section--head">
        <tr class="o-table__row">
          <th class="o-table__heading">Fecha</th>
          <th class="o-table__heading"># de verificación</th>
          <th class="o-table__heading">Descripción</th>
          <th class="o-table__heading">Monto</th>
        </tr>
      </thead>
      <tbody class="o-table__section o-table__section--body">

        <?php foreach ($data['transactions'] as $transaction): ?>

          <tr class="o-table__row">
            <td class="o-table__value"> <?= format_date($transaction['date']) ?> </td>
            <td class="o-table__value"> <?= $transaction['check_number'] ?> </td>
            <td class="o-table__value"> <?= $transaction['description'] ?> </td>
            <td class="o-table__value o-table__value--reverse o-table__value--<?= $transaction['amount'] > 0 ? "positive" : "negative" ?>"> <?= format_amount($transaction['amount']) ?> </td>
          </tr>

        <?php endforeach; ?>

      </tbody>
      <tfoot class="o-table__section o-table__sectio--footer">
        <tr class="o-table__row">
          <th class="o-table__value o-table__value--reverse" colspan="3">Ingresos</th>
          <td class="o-table__value o-table__value--reverse o-table__value--<?= $data['totals']['income'] > 0 ? 'positive' : 'negative' ?>"> <?= format_amount($data['totals']['income']) ?> </td>
        </tr>
        <tr class="o-table__row">
          <th class="o-table__value o-table__value--reverse" colspan="3">Gastos</th>
          <td class="o-table__value o-table__value--reverse o-table__value--<?= $data['totals']['expense'] > 0 ? 'positive' : 'negative' ?>"> <?= format_amount($data['totals']['expense']) ?> </td>
        </tr>
        <tr class="o-table__row">
          <th class="o-table__value o-table__value--reverse" colspan="3">Total</th>
          <td class="o-table__value o-table__value--reverse o-table__value--<?= $data['totals']['total'] > 0 ? 'positive' : 'negative' ?>"> <?= format_amount($data['totals']['total']) ?> </td>
        </tr>
      </tfoot>
    </table>

  <?php endif; ?>

</section>