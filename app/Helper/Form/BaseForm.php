<?php

class BaseForm
{

    public $label;
    public $name;
    public $type       = "text";
    public $isDisabled = false;
//     public $selectValues = [];
    public $value = "";

    public $placeholder = "";
    public $isRequired  = false;

    private $customOutput = "";

    public $model             = null;
    public $isButton          = false;
    public $isArray           = false;
    public $isPhoto           = false;
    public $isHidden          = false;
    public $isReadOnly        = false;
    public $bottomDescription = "";
    public $containerClass =  "col-12";
    public $inputClass =  "";


    public $selectOptions = [];

    public function __construct($label, $name, $type = "text")
    {

        $this->label       = $label;
        $this->name        = $name;
        $this->type        = $type;
        $this->placeholder = "Enter $label";
//         debug($errors->all());
        if (old($this->name)) {
            $this->value = getSemicolonFormat(old($this->name));
        }

//         $this->value  =  old($this->name);

    }


    public function setGone($isGone)
    {
        $this->isDisabled = $isGone;
        $this->isHidden   = $isGone;
        $this->isRequired = !$isGone;
    }

    public function setModel($model)
    {

        if ($model == null) {
            return;
        }
        $name       = $this->name;
        $modelValue = $model->$name;
//        debug($model);
        if ($modelValue != NULL) {
            $this->value = $modelValue;

        }
    }

    public function setInputTypePhoto()
    {
        $this->type    = 'file';
        $this->isPhoto = true;
        $this->label   = "$this->label. Maximum file 5000KB";
    }


    public function setInputTypeSelect($values = [], Illuminate\Database\Eloquent\Collection $model = null)
    {
        $this->placeholder = "Pilih $this->label";
        if ($model != null) {

            foreach ($model as $currentModel) {
                $values[] = $currentModel->name;
            }
        }

        $this->selectOptions = $values;


        $this->type = "select";
    }

    public function setInputTypeCheckbox($values = [], Illuminate\Database\Eloquent\Collection $model = null)
    {


        try {
            $this->type = "checkbox";
            if ($model != null) {
                foreach ($model as $currentModel) {
                    $values[] = $currentModel->name;
                }
            }

            $this->selectOptions = $values;
            $customOutput = "";
//            foreach ($values as $value) {
//                $isChecked = strpos($this->value, $value) > -1 ? "checked" : "";
//                $labelClass = $this->isRequired && !$this->isReadOnly && !$this->isHidden ? "label-required" : "";
//                $ucValue = ucwords($value);
//                $isDisabled = $this->isDisabled ? "disabled" : "";
//            }
        } catch (Exception $e) {
//             debug($this);
        }

    }

    private function getIsRequired()
    {


    }

    public function getValidationRule()
    {
        $validation = [];
        if ($this->isRequired && !$this->isReadOnly && !$this->isHidden) {
            $validation[] = "required";
        }
        if ($this->isArray) {
            $validation[] = "array";
        }

        if ($this->type == "number") {
            $validation[] = "numeric";
        }
        if ($this->isPhoto) {
            $validation[] = "mimes:jpeg,bmp,png";
        }
        if ($this->type == 'file') {
            $validation[] = "max:5000";
        }

        return [$this->name => implode('|', $validation)];

    }
//     private getIsReadOnly(){}
}


?>