<?php

namespace common\components;


use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use common\models\AuthActive;
use common\models\AuthAssign;
use common\models\AuthRef;

/**
 *
 */
class Assign extends Component
{
    /**
     *
     */
    public function getAssign()
    {
        if (Yii::$app->user->isGuest) {

            return null;
        }
        $model = AuthActive::find()
        ->joinWith(['assign'])
        ->where(['auth_assign.id_user' => Yii::$app->user->id])
        ->one();

        return $model ? $model['assign']->assign : null;
    }

    /**
     *
     */
    public function isAdministrator()
    {
        return $this->getAssign() == AuthAssign::ADMINISTRATOR;
    }

    /**
     *
     */
    public function isPenjual()
    {
        return $this->getAssign() == AuthAssign::PENJUAL;
    }

    /**
     *
     */
    public function isPembeli()
    {
        return $this->getAssign() == AuthAssign::PEMBELI;
    }

    /**
     *
     */
    public function isBoth()
    {
        return $this->isAdministrator() || $this->isPenjual() || $this->isPembeli();
    }

    /**
     *
     */
    public function is($assign)
    {
        if (is_array($assign)) {

            $is = false;
            foreach ($assign as $_assign) {
                $_is = $this->getAssign() == $_assign;
                $is  = $is || $_is;
            }
        } else {
            $is = $this->getAssign() == $assign;
        }

        return $is;
    }

    /**
     *
     */
    public function setAssign($assign = null, $id_user = null)
    {
        $id_user    = $id_user ? : Yii::$app->user->id;
        $listAssign = $this->listAssign($id_user);
        if (empty($listAssign)) {

            return false;
        }

        $last   = ! ((bool) $assign);
        $assign = $assign ? : array_values($listAssign)[0];
        if ($this->hasAssign($assign)) {
            $model = AuthActive::find()
            ->joinWith(['assign'])
            ->where(['auth_assign.id_user' => $id_user])
            ->one();

            if ($last && $model) {

                return true;
            }

            if ($model) {
                $model->delete();
            }

            $model            = new AuthActive();
            $model->id_assign = array_search($assign, $listAssign);

            return $model->save();
        }

        return false;
    }

    /**
     *
     */
    public function deleteAssign($assign = null, $id_user = null)
    {
        $listAssign = $this->listAssign($id_user);
        if (empty($listAssign)) {

            return false;
        }

        $assign = $assign ? : array_values($listAssign)[0];
        if ($this->hasAssign($assign)) {
            $model = AuthActive::findOne(array_search($assign, $listAssign));
            if ($model) {
                return $model->delete();
            }
        }

        return false;
    }

    /**
     *
     */
    public function addAssign($assign, $id_user)
    {
        $model = AuthAssign::find()
        ->where(['id_user' => $id_user, 'assign' => $assign])
        ->one();

        if (!$model) {
            $model = new AuthAssign();
            $model->id_user = $id_user;
            $model->assign  = $assign;

            return $model->save();
        }

        return false;
    }

    /**
     *
     */
    public function revokeAssign($assign, $id_user)
    {
        $model = AuthAssign::find()
        ->joinWith(['authActive'])
        ->where(['id_user' => $id_user, 'assign' => $assign])
        ->one();

        if (!empty($model['authActive'])) {
            $model['authActive']->delete();
        }

        return $model->delete();
    }

    /**
     *
     */
    public function listRef()
    {
        $model = AuthRef::find()->orderBy('assign ASC')->all();
        $model = ArrayHelper::map($model, 'assign', 'assign');

        return $model;
    }

    /**
     *
     */
    public function listAssign($id_user = null)
    {
        if (Yii::$app->user->isGuest) {

            return [];
        }
        $id_user = $id_user ? : Yii::$app->user->id;
        $model   = AuthAssign::find()
        ->where(['id_user' => $id_user])
        ->orderBy('assign ASC')
        ->all();
        $model = ArrayHelper::map($model, 'id', 'assign');

        return $model;
    }

    /**
     *
     */
    public function hasAssign($assign, $id_user = null)
    {
        $model   = $this->listAssign($id_user);
        if (is_array($assign)) {
            $_assign = false;
            foreach ($assign as $value) {
                $_assign = $_assign || in_array($value, $model);
            }
        } else {
            $_assign = in_array($assign, $model);
        }

        return $_assign;
    }
}
