<?php

namespace Sk\Mid;

use Sk\Mid\Exception\MissingOrInvalidParameterException;
use Sk\Mid\HashType\HashType;

class MobileIdSignatureResult
{

    /** @var string $result */
    private $result;

    /** @var string $signedHashInBase64 */
    private $signedHashInBase64;

    /** @var HashType $hashType */
    private $hashType;

    /** @var string $signatureValueInBase64 */
    private $signatureValueInBase64;

    /** @var string $algorithmName */
    private $algorithmName;

    public function __construct(MobileIdSignatureResultBuilder $builder)
    {
        $this->result = $builder->getResult();
        $this->signedHashInBase64 = $builder->getSignedHashInBase64();
        $this->hashType = $builder->getHashType();
        $this->signatureValueInBase64 = $builder->getSignatureValueInBase64();
        $this->algorithmName = $builder->getAlgorithmName();
    }

    public function getSignatureValue(): string
    {
        $decodedBase64 = base64_decode($this->signatureValueInBase64, true);
        if (false === $decodedBase64) {
            throw new MissingOrInvalidParameterException("Failed to parse signature value. Input is not valid Base64 string: '" . $this->signatureValueInBase64 . "'");
        } else {
            return $decodedBase64;
        }
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function getSignedHashInBase64(): string
    {
        return $this->signedHashInBase64;
    }

    public function getHashType(): ?HashType
    {
        return $this->hashType;
    }

    public function getSignatureValueInBase64(): ?string
    {
        return $this->signatureValueInBase64;
    }

    public function getAlgorithmName(): string
    {
        return $this->algorithmName;
    }

    public static function newBuilder(): MobileIdSignatureResultBuilder
    {
        return new MobileIdSignatureResultBuilder();
    }
}
