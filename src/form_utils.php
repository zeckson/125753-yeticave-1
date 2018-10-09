<?php
function mark(&$var, $value = 'form__item--invalid')
{
    return mark_if_true(isset($var), $value);
}

function mark_if_true($condition, $value = 'form__item--invalid')
{
    return $condition ? $value : '';
}

