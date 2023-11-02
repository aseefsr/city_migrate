<?php

namespace Drupal\migrate_city\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the city entity edit forms.
 */
class CityForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New city %label has been created.', $message_arguments));
        $this->logger('migrate_city')->notice('Created new city %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The city %label has been updated.', $message_arguments));
        $this->logger('migrate_city')->notice('Updated city %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.city.canonical', ['city' => $entity->id()]);

    return $result;
  }

}
