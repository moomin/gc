<?php
if ($errors):
    echo '<ul class="formErrors">';
    foreach ($errors as $error):
        echo '<li>' .$error. '</li>';
    endforeach;
    echo '</ul>';
endif;
