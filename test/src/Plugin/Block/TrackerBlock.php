<?php

namespace Drupal\test\Plugin\Block;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a 'test' Block.
 *
 * @Block(
 *   id = "tracker_block",
 *   admin_label = @Translation("BTR tracking"),
 *   category = @Translation("Test"),
 * )
 */
class TrackerBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['ajax_link'] = [
      '#type' => 'details',
      '#title' => $this->t('This is the AJAX link'),
      '#open' => TRUE,
    ];
    // We build the AJAX link.
    $build['ajax_link']['link'] = [
      '#type' => 'link',
      '#title' => $this->t('Click me'),
      // We have to ensure that Drupal's Ajax system is loaded.
      '#attached' => ['library' => ['core/drupal.ajax']],
      // We add the 'use-ajax' class so that Drupal's AJAX system can spring
      // into action.
      '#attributes' => ['class' => ['use-ajax']],
      // The URL for this link element is the callback. In our case, it's route
      // ajax_example.ajax_link_callback, which maps to ajaxLinkCallback()
      // below. The route has a /{nojs} section, which is how the callback can
      // know whether the request was made by AJAX or some other means where
      // JavaScript won't be able to handle the result. If the {nojs} part of
      // the path is replaced with 'ajax', then the request was made by AJAX.
      '#url' => Url::fromRoute('test.ajax_link_callback', ['nojs' => 'ajax']),
    ];

    $routeMetch = \Drupal::routeMatch();
    $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $build['test']['#markup'] = "<div id=\"tracking_brt\"> bocco test2 </div>";

    /*
    // $node = \Drupal::entityTypeManager()->getStorage('node')->load(2);

    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
      // You can get nid and anything else you need from the node object.
      $nid = $node->id();
      //dpm($nid);
      //dpm($node->get('body')->get(0)->value);
      $view = views_embed_view('test_block_img', 'block_img', $nid);
      $build['#markup'] .= render($view);

      //$build['#markup'] .= ;
    //  exit();
    }

    //$node = $this->entityTypeManager->getStorage('node')->load(2);
*/

/*
    if($routeMetch->getRouteName() != 'entity.commerce_order.user_view') {
      return ['#markup' => t("Errore nella configuraaione del blocco")];
    }
    $user_id = $routeMetch->getRawParameter('user');
    $account = \Drupal::currentUser();
    if($account->id() != 1 && ($account->id() != $user_id)) { return ['#markup' => ""]; }
    $build['#markup'] = t("Il tracciamento del pacco al momento non è disponibile.");
    $order = \Drupal\commerce_order\Entity\Order::load(
      $routeMetch->getRawParameter('commerce_order')
    );
    if ($order->hasField('shipments') && !$order->get('shipments')->isEmpty()) {
      $shipments = $order->get('shipments')->referencedEntities()[0];
      if($shipments->hasField('tracking_code') && !$shipments->get('tracking_code')->isEmpty()) {
        $build['#attached']['drupalSettings']['dogma_brt']['code'] = $shipments->get('tracking_code')->get(0)->value;
        $build['#attached']['drupalSettings']['dogma_brt']['lenguage'] = $language;
        $build['#markup'] = "<div id=\"tracking_brt\"><div id=\"TRNum\"> </div></div>";
        $build['#attached']['library'][] = 'dogmautil/dogmautil';
      }
    }
    */
    return $build;
  }

    /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['hello_block_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Who'),
      '#description' => $this->t('Who do you want to say hello to?'),
      '#default_value' => $config['hello_block_name'] ?? '',
    ];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
   public function blockSubmit($form, FormStateInterface $form_state) {
     parent::blockSubmit($form, $form_state);
     $values = $form_state->getValues();
     $this->configuration['hello_block_name'] = $values['hello_block_name'];
   }
   /**
  * {@inheritdoc}
  */
 public function blockValidate($form, FormStateInterface $form_state) {
   if ($form_state->getValue('hello_block_name') === 'John') {
     $form_state->setErrorByName('hello_block_name', $this->t('You can not say hello to John.'));
   }
 }

}
