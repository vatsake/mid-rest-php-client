<?php

namespace Sk\Mid;

use Sk\Mid\HashType\HashType;

class MobileIdSignatureResultBuilder
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

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function getSignedHashInBase64(): ?string
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

    public function getAlgorithmName(): ?string
    {
        return $this->algorithmName;
    }

    public function withResult(string $result): self
    {
        $this->result = $result;
        return $this;
    }

    public function withSignedHashInBase64(string $signedHashInBase64): self
    {
        $this->signedHashInBase64 = $signedHashInBase64;
        return $this;
    }

    public function withHashType(?HashType $hashType): self
    {
        $this->hashType = $hashType;
        return $this;
    }

    public function withSignatureValueInBase64(string $signatureValueInBase64): self
    {
        $this->signatureValueInBase64 = $signatureValueInBase64;
        return $this;
    }

    public function withAlgorithmName(string $algorithmName): self
    {
        $this->algorithmName = $algorithmName;
        return $this;
    }

    public function build(): MobileIdSignatureResult
    {
        return new MobileIdSignatureResult($this);
    }
}
