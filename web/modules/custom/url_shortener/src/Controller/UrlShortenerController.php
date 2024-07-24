<?php

namespace Drupal\url_shortener\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Response;

class UrlShortenerController extends ControllerBase {

  public function content() {
    $form = \Drupal::formBuilder()->getForm('Drupal\url_shortener\Form\UrlShortenerForm');
    $table = $this->buildTable();

    return [
      '#type' => 'container',
      '#children' => [
        'form' => $form,
        'table' => $table,
      ],
    ];
  }

  private function buildTable() {
    $header = ['short URL', 'original URL'];
    $rows = [];

    $connection = Database::getConnection();
    $query = $connection->select('drupal_url_shortner', 'u')
      ->fields('u', ['short_url' ,'long_url' ])
      ->execute();

    foreach ($query as $record) {
      $rows[] = [$record->short_url,$record->long_url];
    }

    $build['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];

    return $build;
  }
}
