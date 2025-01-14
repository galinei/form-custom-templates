<?php

declare(strict_types=1);

namespace B13\FormCustomTemplates\Hooks;

use B13\FormCustomTemplates\Service\EmailTemplateService;

class DataStructureEmailOptionsHook
{
    /**
     * Add emailTemplateUid options
     *
     * @param array $dataStructure
     * @param array $identifier
     * @return array
     */
    public function parseDataStructureByIdentifierPostProcess(array $dataStructure, array $identifier): array
    {
        if (($identifier['ext-form-overrideFinishers'] ?? '') === 'enabled') {
            $addToFinishers = ['EmailToSender', 'EmailToReceiver'];
            $options = EmailTemplateService::getOptions();

            // Search for finishers and add items
            foreach ($dataStructure['sheets'] as $sheetIdentifier => $sheet) {
                foreach ($addToFinishers as $finisherIdentifier) {
                    if ($dataStructure['sheets'][$sheetIdentifier]['ROOT']['el']['settings.finishers.' . $finisherIdentifier . '.emailTemplateUid'] ?? false) {
                        $allOptions = array_merge($dataStructure['sheets'][$sheetIdentifier]['ROOT']['el']['settings.finishers.' . $finisherIdentifier . '.emailTemplateUid']['TCEforms']['config']['items'], $options);
                        $dataStructure['sheets'][$sheetIdentifier]['ROOT']['el']['settings.finishers.' . $finisherIdentifier . '.emailTemplateUid']['TCEforms']['config']['items'] = $allOptions;
                    }
                }
            }
        }

        return $dataStructure;
    }
}
