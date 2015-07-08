<?php
    /**
     * @param $routeParams
     */
    function delete_form($routeParams, $label = 'Delete'){
        $form =  Form::open(['method' => 'DELETE', 'route' => $routeParams ]);
        $form .= Form::submit($label, ['class' => 'btn btn-danger']);
        $form .= Form::close();

        return $form;
    }
?>