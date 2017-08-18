<?php

namespace LimeSurvey\Models\SurveyTraits;

use \Survey as SurveyModel;

trait SurveyCaptchaTrait
{
    /**
     * Transcribe from 3 checkboxes to 1 char for captcha usages
     * Uses variables from $_POST
     *
     * @param string $surveyAccess
     * @param string $registration
     * @param string $saveAndLoad
     *
     * @return string One character that corresponds to captcha usage
     */
    private static function getSurveyCaptchaSettingChar($surveyAccess, $registration, $saveAndLoad)
    {
        if ($surveyAccess === '1' && $registration === '1' && $saveAndLoad === '1') {
            return SurveyModel::CAPTCHA_ALL_THREE_ENABLED;
        } elseif ($surveyAccess === '1' && $registration === '1') {
            return SurveyModel::CAPTCHA_ALL_BUT_SAVE_AND_LOAD;
        } elseif ($surveyAccess === '1' && $saveAndLoad === '1') {
            return SurveyModel::CAPTCHA_ALL_BUT_REGISTRATION;
        } elseif ($registration === '1' && $saveAndLoad === '1') {
            return SurveyModel::CAPTCHA_ALL_BUT_SURVEY_ACCESS;
        } elseif ($surveyAccess === '1') {
            return SurveyModel::CAPTCHA_ONLY_SURVEY_ACCESS;
        } elseif ($registration === '1') {
            return SurveyModel::CAPTCHA_ONLY_REGISTRATION;
        } elseif ($saveAndLoad === '1') {
            return SurveyModel::CAPTCHA_ONLY_SAVE_AND_LOAD;
        }

        return SurveyModel::CAPTCHA_NONE;
    }

    /**
     * Transcribe from 3 checkboxes to 1 char for captcha usages
     * Uses variables from $_POST
     *
     * @return string One character that corresponds to captcha usage
     * @todo Should really be saved as three fields in the database!
     */
    public static function transcribeCaptchaOptions()
    {
        $surveyAccess = App()->request->getPost('usecaptcha_surveyaccess');
        $registration = App()->request->getPost('usecaptcha_registration');
        $saveAndLoad = App()->request->getPost('usecaptcha_saveandload');

        return self::getSurveyCaptchaSettingChar($surveyAccess, $registration, $saveAndLoad);
    }

    /**
     * Transcribe from 3 checkboxes to 1 char for captcha usages
     * Uses variables from $_POST and transferred Survey object
     *
     * @param \Survey $oSurvey
     *
     * @return string One character that corresponds to captcha usage
     * @todo Should really be saved as three fields in the database!
     */
    public static function saveTranscribeCaptchaOptions(SurveyModel $oSurvey)
    {
        $surveyAccess = App()->request->getPost('usecaptcha_surveyaccess', null);
        $registration = App()->request->getPost('usecaptcha_registration', null);
        $saveAndLoad = App()->request->getPost('usecaptcha_saveandload', null);

        if ($surveyAccess === null && $registration === null && $saveAndLoad === null) {
            return $oSurvey->usecaptcha;
        }

        return self::getSurveyCaptchaSettingChar($surveyAccess, $registration, $saveAndLoad);
    }
}
