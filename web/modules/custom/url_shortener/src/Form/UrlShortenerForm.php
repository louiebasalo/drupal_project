<?php

namespace Drupal\url_shortener\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\url_shortener\Form\UrlShortenerService;

class UrlShortenerForm extends FormBase {

  public function getFormId() {
    return 'url_shortener_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['long_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Long URL'),
      '#description' => $this->t('Enter the long URL to shorten.'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Shorten URL'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $long_url = $form_state->getValue('long_url');
    $short = new UrlShortenerService();
    $short_url = $short->generateShortCode($long_url);

    $connection = Database::getConnection();
    $connection->insert('drupal_url_shortner')
      ->fields([
        'long_url' => $long_url,
        'short_url' => $short_url,
      ])
      ->execute();

    $this->messenger()->addMessage($this->t('URL shortened successfully! Short URL: !short_url', ['!short_url' => $short_url]));
    $form_state->setRebuild(TRUE);
  }

}
