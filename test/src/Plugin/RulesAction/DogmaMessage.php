<?php

namespace Drupal\test\Plugin\RulesAction;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\Markup;
use Drupal\rules\Core\RulesActionBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Show a message on the site' action.
 *
 * @RulesAction(
 *   id = "rules_dogma_message",
 *   label = @Translation("Show a message on the site"),
 *   category = @Translation("Dogma"),
 *   context_definitions = {
 *     "message" = @ContextDefinition("string",
 *       label = @Translation("Message"),
 *       description = @Translation("The text to display. HTML is allowed.")
 *     ),
 *     "type" = @ContextDefinition("string",
 *       label = @Translation("Message type"),
 *       description = @Translation("The message type: status, warning, or error."),
 *       default_value = "status",
 *       required = FALSE
 *     ),
 *     "repeat" = @ContextDefinition("boolean",
 *       label = @Translation("Repeat message"),
 *       description = @Translation("If disabled and the message has been already shown, then the message won't be repeated."),
 *       assignment_restriction = "input",
 *       default_value = TRUE,
 *       required = FALSE
 *     ),
 *   }
 * )
 *
 * @todo Add access callback information from Drupal 7.
 */
class DogmaMessage extends RulesActionBase implements ContainerFactoryPluginInterface {

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a SystemMessage object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MessengerInterface $messenger) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->messenger = $messenger;
  }
  private function log($somecontent) {
    dpm("ok");
    $filename = '/tmp/drupal.txt';
    $somecontent = "Add this to the file\n";

// Let's make sure the file exists and is writable first.
if (is_writable($filename)) {

    // In our example we're opening $filename in append mode.
    // The file pointer is at the bottom of the file hence
    // that's where $somecontent will go when we fwrite() it.
    if (!$handle = fopen($filename, 'a')) {
         echo "Cannot open file ($filename)";
         exit;
    }

    // Write $somecontent to our opened file.
    if (fwrite($handle, $somecontent) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }

    echo "Success, wrote ($somecontent) to file ($filename)";

    fclose($handle);

} else {
    echo "The file $filename is not writable";
}
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('messenger')
    );
  }

  /**
   * Set a system message.
   *
   * @param string $message
   *   Message string that should be set.
   * @param string $type
   *   Type of the message.
   * @param bool $repeat
   *   (optional) TRUE if the message should be repeated.
   */
  protected function doExecute($message, $type, $repeat) {
    // @todo Should we do the sanitization somewhere else? D7 had the sanitize
    // flag in the context definition.

    dpm($type);
    dpm($message);
    dpm($repeat);

    $this->log($type);
    exit;
    //$message = Xss::filterAdmin("test");
    //$repeat = (bool) $repeat;
    // $this->messenger->addMessage(Markup::create("ciao"), 'status', TRUE);

  }

}
