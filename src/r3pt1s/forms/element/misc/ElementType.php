<?php

namespace r3pt1s\forms\element\misc;

enum ElementType: string {

    case BUTTON = "button";
    case LABEL = "label";
    case HEADER = "header";
    case DIVIDER = "divider";
    case DROPDOWN = "dropdown";
    case INPUT = "input";
    case SLIDER = "slider";
    case STEP_SLIDER = "step_slider";
    case TOGGLE = "toggle";
}