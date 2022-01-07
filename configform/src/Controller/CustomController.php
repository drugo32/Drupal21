<?php

namespace Drupal\configform\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\examples\Utility\DescriptionTemplateTrait;
/**/
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\Core\Ajax\AddCssCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Url;
//use Drupal\examples\Utility\DescriptionTemplateTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller routinesuse Drupal\Core\Url; for page example routes.
 */
class CustomController extends ControllerBase {

  use DescriptionTemplateTrait;

  /**
   * {@inheritdoc}
   */
  protected function getModuleName() {
    return 'configform';
  }

  /**
   * Constructs a simple page.
   *
   * The router _controller callback, maps the path
   * 'examples/page-example/simple' to this method.
   *
   * _controller callbacks return a renderable array for the content area of the
   * page. The theme system will later render and surround the content with the
   * appropriate blocks, navigation, and styling.
   */
  public function CustomViews($display) {
    $build = [];
    if($display!='') {
      $display_valid = ['a','b'];
      if(!in_array($display, $display_valid))
        return ['#markup' => 'args error'];

      if($display == 'a') {
        $output = $this->t("via AJAX DI DISPLAY A");
      }
      else if($display == 'b') {
        $output = $this->t("via AJAX DI DISPLAY B");
      }
      $response = new AjaxResponse();
      //  $response->addCommand(new AppendCommand('#ajax-example-destination-div', $output));
/*
      $elem  = [
        'type' => 'item',
        '#attributes' => ['id'=>"edit-date-format-suffix"],
        '#markup' => $output,
      ];
*/
      $response->addCommand(new ReplaceCommand('#edit-date-format-suffix', '<div id="edit-date-format-suffix">' . $output . '</div>'));
/*
      $response->addCommand(
        new ReplaceCommand(
          '#edit-date-format-suffix',
          render($elem)
        )
      );
*/
      // See ajax_example_advanced.inc for more details on the available
      // commands and how to use them.
      // $page = array('#type' => 'ajax', '#commands' => $commands);
      // ajax_deliver($response);

      //$CssString = '<style>.myclass{color:red;}</style>'; /*A string that contains the styles to be added to the page, including the wrapping <style> tag.*/
      //$response->addCommand(new AddCssCommand($CssString));
      return $response;
    }
    /**/
    $build['tabs'] = [
      '#type' => 'item',
      '#markup' =>' tabs ',
      '#attached' => ['library' => ['core/drupal.ajax']],
    ];
    $build['tabs']['mode1'] = [
      '#type' => 'link',
      '#title' => $this->t('Link 1'),
      '#attributes' => ['class' => ['use-ajax','myclass']],
      '#url' => Url::fromRoute('config_form.views_node_tab', ['display' => 'a']),
    ];
    $build['tabs']['mode2'] = [
      '#type' => 'link',
      '#title' => $this->t('Link 2'),
      '#attributes' => ['class' => ['use-ajax','myclass']],
      '#url' => Url::fromRoute('config_form.views_node_tab', ['display' => 'b']),
    ];
    $build['ajax_link']['destination'] = [
      '#type' => 'container',
      '#attributes' => ['id' => ['ajax-example-destination-div']],
      '#markup' => "...... default value ..... ",
    ];
    $build['ajax_link']['test'] = [
      '#type' => 'container',
      '#attributes' => ['id' => ['edit-date-format-suffix']],
      '#markup' => "....",
    ];

    /*
    $build['my_div'] = [
      '#markup' => $this->t('
  The link below has been rendered as an element with the #ajax property, so if
  javascript is enabled, ajax.js will try to submit it via an AJAX call instead
  of a normal page load. The URL also contains the "/nojs/" magic string, which
  is stripped if javascript is enabled, allowing the server code to tell by the
  URL whether JS was enabled or not, letting it do different things based on that.'),
    ];

    // We'll add a nice border element for our demo.


    $build['ajax_link'] = [
      '#type' => 'details',
      '#title' => $this->t('This is the AJAX link-2'),
      '#open' => FALSE,
    ];
    // We build the AJAX link.
    $build['ajax_link']['link'] = [
      '#type' => 'link',
      '#title' => $this->t('Click me'),
      // We have to ensure that Drupal's Ajax system is loaded.
      '#attached' => ['library' => ['core/drupal.ajax']],
      // We add the 'use-ajax' class so that Drupal's AJAX system can spring
      // into action.
      '#attributes' => ['class' => ['use-ajax','myclass']],
      // The URL for this link element is the callback. In our case, it's route
      // ajax_example.ajax_link_callback, which maps to ajaxLinkCallback()
      // below. The route has a /{nojs} section, which is how the callback can
      // know whether the request was made by AJAX or some other means where
      // JavaScript won't be able to handle the result. If the {nojs} part of
      // the path is replaced with 'ajax', then the request was made by AJAX.
      '#url' => Url::fromRoute('ajax_example.ajax_link_callback', ['nojs' => 'nojs']),
    ];
    */
    // We provide a DIV that AJAX can append some text into.

    return $build;
  }


}
