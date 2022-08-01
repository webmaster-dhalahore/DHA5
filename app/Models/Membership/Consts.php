<?php

namespace App\Models\Membership;

class Consts
{
    const STATUS = ['ACTIVE', 'CANCEL', 'OTHER'];
    const STATUSES = [
        ['value' => 'ACTIVE', 'label' => 'ACTIVE', 'selected' => true],
        ['value' => 'CANCEL', 'label' => 'CANCEL', 'selected' => false],
        ['value' => 'OTHER', 'label' => 'OTHER', 'selected' => false],
    ];
    const BLOCK_STATUS = ['ACTIVE', 'BLOCK', 'CANCEL', 'OUTSTATION'];
    const BLOCK_STATUSES = [
        ['value' => 'ACTIVE', 'label' => 'ACTIVE', 'selected' => true],
        ['value' => 'BLOCK', 'label' => 'BLOCK', 'selected' => false],
        ['value' => 'CANCEL', 'label' => 'CANCEL', 'selected' => false],
        ['value' => 'OUTSTATION', 'label' => 'OUTSTATION', 'selected' => false],
    ];
    const TYPE = ['MEMBER', 'OTHER'];
    const TYPES = [
        ['value' => 'MEMBER', 'label' => 'MEMBER', 'selected' => true],
        ['value' => 'OTHER', 'label' => 'OTHER', 'selected' => false],
    ];

    const MEMBER_TYPE_SUB = ['EXEC COMMITTEE', 'DHA OFFICERS'];
    const MEMBER_TYPE_SUBS = [
        ['value' => 'EXEC COMMITTEE', 'label' => 'EXEC COMMITTEE', 'selected' => false],
        ['value' => 'DHA OFFICERS', 'label' => 'DHA OFFICERS', 'selected' => false],
    ];

    // FAMILY CONSTANTS
    const CREDITALLOWED = [0, 1];
    const CREDIT_ALLOWED = [
        ['value' => 1, 'label' => 'YES', 'selected' => false],
        ['value' => 0, 'label' => 'NO', 'selected' => true],
    ];
    const RELATION = ['WIFE', 'SON', 'DAUGHTER', 'HUSBAND', 'FATHER', 'MOTHER', 'GRAND FATHER', 'GRAND MOTHER'];
    const RELATIONS = [
        ['value' => 'WIFE', 'label' => 'WIFE', 'selected' => false],
        ['value' => 'SON', 'label' => 'SON', 'selected' => true],
        ['value' => 'DAUGHTER', 'label' => 'DAUGHTER', 'selected' => false],
        ['value' => 'HUSBAND', 'label' => 'HUSBAND', 'selected' => false],
        ['value' => 'FATHER', 'label' => 'FATHER', 'selected' => false],
        ['value' => 'MOTHER', 'label' => 'MOTHER', 'selected' => false],
        ['value' => 'GRAND FATHER', 'label' => 'GRAND FATHER', 'selected' => false],
        ['value' => 'GRAND MOTHER', 'label' => 'GRAND MOTHER', 'selected' => false],
    ];

    const IMAGES_PATH = 'images' . DIRECTORY_SEPARATOR . 'memberpics';
}
