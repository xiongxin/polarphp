<?php
// RUN: %{polarphp} %s 1> %t.out 2>&1
// RUN: filechecker --input-file %t.out %s

if (class_exists("\NonMagicMethodClass") && class_exists("\MagicMethodClass")) {
    $nonMagicMethodObject = new NonMagicMethodClass();
    // $nonMagicMethodObject->prop1; Notice: Undefined property: NonMagicMethodClass::$prop1
    if (!property_exists($nonMagicMethodObject, "prop1")) {
        echo "\$nonMagicMethodObject->prop1 is not exist\n";
    }
    $magicMethodObject = new MagicMethodClass();
    if (property_exists($magicMethodObject, "prop1")) {
        echo "\$magicMethodObject->prop1 is exist\n";
        echo "the value of \$magicMethodObject->prop1 is ".$magicMethodObject->prop1."\n";
    }
}

// CHECK: $nonMagicMethodObject->prop1 is not exist
// CHECK: MagicMethodClass::__isset is called
// CHECK: $magicMethodObject->prop1 is exist
// CHECK: MagicMethodClass::__get is called
// CHECK: the value of $magicMethodObject->prop1 is polarphp