<?php

/*
 * This file is part of the IRMediaBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\MediaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use IR\Bundle\MediaBundle\Model\MediaInterface;

/**
 * File validator.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class FileValidator extends ConstraintValidator
{
    protected $validator;


    public function __constructor($validator)
    {   
        $this->validator = $validator;
    }


    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof MediaInterface) {
            return;
        }
    }
}
