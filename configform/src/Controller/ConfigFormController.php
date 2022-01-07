<?php

namespace Drupal\configform\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\examples\Utility\DescriptionTemplateTrait;

/**
 * Controller routines for page example routes.
 */
class ConfigFormController extends ControllerBase {

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
  public function simple() {
/*

    $rest_config = $config_factory->getEditable('configform.settings');
    $rest_config
      ->set('server_url', $form_values['server_url'])
      ->set('server_username', $form_values['server_username'])
      ->set('server_password', $form_values['server_password'])
      ->save();
*/
  //$config_factory = \Drupal::configFactory();
     dpm($this->config('configform.settings')->get('server_url'));
     dpm($this->config('configform.settings')->get('server_username'));
     dpm($this->config('configform.settings')->get('server_password'));

     $v = views_embed_view('node_slide','block_1', $this->config('configform.settings')->get('server_url'));
     //dpm(render($v));
     $attachments['#attached']['drupalSettings']['myvar'] = $myVariable;
    return [
      '#attached' => [
        'drupalSettings' => ['myvar' => 'php_vars'],
        'library' => 'configform/slide-js'
      ],
      '#markup' => render($v) . '<div class="splide">
  <div class="splide__track">  <ul class="splide__list">
      <li class="splide__slide">Slide 01</li>
      <li class="splide__slide">Slide 02</li>
      <li class="splide__slide">Slide 03</li>
    </ul></div>
</div>',
    ];
  }

  /**

   * A more complex _controller callback that takes arguments.
   *
   * This callback is mapped to the path
   * 'examples/page-example/arguments/{first}/{second}'.
   *
   * The arguments in brackets are passed to this callback from the page URL.
   * The placeholder names "first" and "second" can have any value but should
   * match the callback method variable names; i.e. $first and $second.
   *
   * This function also demonstrates a more complex render array in the returned
   * values. Instead of rendering the HTML with theme('item_list'), content is
   * left un-rendered, and the theme function name is set using #theme. This
   * content will now be rendered as late as possible, giving more parts of the
   * system a chance to change it if necessary.
   *
   * Consult @link http://drupal.org/node/930760 Render Arrays documentation
   * @endlink for details.
   *
   * @param string $first
   *   A string to use, should be a number.
   * @param string $second
   *   Another string to use, should be a number.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
   *   If the parameters are invalid.
   */
  public function arguments($first, $second) {
    // Make sure you don't trust the URL to be safe! Always check for exploits.
    if (!is_numeric($first) || !is_numeric($second)) {
      // We will just show a standard "access denied" page in this case.
      throw new AccessDeniedHttpException();
    }

    $list[] = $this->t("First number was @number.", ['@number' => $first]);
    $list[] = $this->t("Second number was @number.", ['@number' => $second]);
    $list[] = $this->t('The total was @number.', ['@number' => $first + $second]);

    $render_array['page_example_arguments'] = [
      // The theme function to apply to the #items.
      '#theme' => 'item_list',
      // The list itself.
      '#items' => $list,
      '#title' => $this->t('Argument Information'),
    ];
    return $render_array;
  }

}
