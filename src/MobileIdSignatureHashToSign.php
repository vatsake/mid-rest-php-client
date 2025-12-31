<?php

namespace Sk\Mid;

use Sk\Mid\Exception\MissingOrInvalidParameterException;
use Sk\Mid\HashType\HashType;
use Sk\Mid\HashType\Sha256;
use Sk\Mid\HashType\Sha384;
use Sk\Mid\HashType\Sha512;

class MobileIdSignatureHashToSign
{
    /** @var string $hash */
    private $hash;

    /** @var string $hash */
    private $hashInBase64;

    /** @var HashType $hashType */
    private $hashType;


    public function __construct(MobileIdSignatureHashToSignBuilder $builder)
    {
        if ($builder->getHashInBase64() !== null) {
            $this->hashInBase64 = $builder->getHashInBase64();
            $this->hash = base64_decode($this->hashInBase64);
        } else if ($builder->getHash() !== null) {
            $this->hash = $builder->getHash();
        }
        $this->hashType = $builder->getHashType();
    }

    public function getHashInBase64(): string
    {
        if (null !== $this->hashInBase64) {
            return $this->hashInBase64;
        } else {
            return base64_encode($this->hash);
        }
    }

    public function getHashType(): HashType
    {
        return $this->hashType;
    }

    public function calculateVerificationCode(): string
    {
        return VerificationCodeCalculator::calculateMobileIdVerificationCode(bin2hex($this->hash));
    }

    public static function newBuilder(): MobileIdSignatureHashToSignBuilder
    {
        return new MobileIdSignatureHashToSignBuilder();
    }

    public static function strToHashType($hashTypeStr): HashType
    {

        switch ($hashTypeStr) {
            case 'sha256':
                return new Sha256();
            case  'sha384':
                return new Sha384();
            case 'sha512':
                return new Sha512();
        }
        throw new MissingOrInvalidParameterException("Unknown hash type " . $hashTypeStr);
    }
}
