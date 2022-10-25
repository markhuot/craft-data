<?php

namespace markhuot\craftdata;

use Craft;
use craft\base\Plugin;
use craft\web\Controller;
use markhuot\craftdata\attributes\BodyParams;
use markhuot\craftdata\behaviors\ActionDataBehavior;
use yii\base\ActionEvent;
use yii\base\Event;

class Data extends Plugin
{
    function init()
    {
        Craft::setAlias('@craftdata', $this->getBasePath());

        Event::on(
            Controller::class,
            Controller::EVENT_BEFORE_ACTION,
            function (ActionEvent $event) {
                $reflect = new \ReflectionClass($event->sender);
                $methodName = 'action' . ucfirst($event->action->id);
                if (!$reflect->hasMethod($methodName)) {
                    return;
                }

                $method = $reflect->getMethod($methodName);
                $attrs = $method->getAttributes(BodyParams::class);
                if (empty($attrs[0])) {
                    return;
                }

                $dataClass = $attrs[0]->newInstance()->dataClass;
                $bodyParams = $event->sender->request->getBodyParams();
                $data = (new Data(new $dataClass))
                    ->fill($bodyParams)
                    ->validate()
                    ->get();

                $event->sender->attachBehaviors([ActionDataBehavior::class]);
                $event->sender->setData($data);
            }
        );
    }
}
