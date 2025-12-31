<?php

namespace Sk\Mid\Rest\Dao\Request;

use Sk\Mid\MobileIdSignatureHashToSign;
use Sk\Mid\Exception\MissingOrInvalidParameterException;
use Sk\Mid\Language\Language;
use Sk\Mid\HashType\HashType;
use Sk\Mid\Util\MidInputUtil;

class SignatureRequestBuilder
{
    /** @var ?string $relyingPartyName */
    private ?string $relyingPartyName = null;

    /** @var ?string $relyingPartyUUID */
    private ?string $relyingPartyUUID = null;

    /** @var ?string $phoneNumber */
    private string $phoneNumber;

    /** @var ?string $nationalIdentityNumber */
    private string $nationalIdentityNumber;

    /** @var ?MobileIdSignatureHashToSign $hashToSign */
    private ?MobileIdSignatureHashToSign $hashToSign = null;

    /** @var ?Language $language */
    private ?Language $language = null;

    /** @var ?string $displayText */
    private ?string $displayText = null;

    /** @var ?string $displayTextFormat */
    private ?string $displayTextFormat = null;


    public function withRelyingPartyUUID(?string $relyingPartyUUID): self
    {
        $this->relyingPartyUUID = $relyingPartyUUID;
        return $this;
    }

    public function withRelyingPartyName(?string $relyingPartyName): self
    {
        $this->relyingPartyName = $relyingPartyName;
        return $this;
    }

    public function withPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function withNationalIdentityNumber(string $nationalIdentityNumber): self
    {
        $this->nationalIdentityNumber = $nationalIdentityNumber;
        return $this;
    }

    public function withHashToSign(MobileIdSignatureHashToSign $hashToSign): self
    {
        $this->hashToSign = $hashToSign;
        return $this;
    }

    public function withLanguage(Language $language): self
    {
        $this->language = $language;
        return $this;
    }

    public function withDisplayText(string $displayText): self
    {
        $this->displayText = $displayText;
        return $this;
    }

    public function withDisplayTextFormat(string $displayTextFormat): self
    {
        $this->displayTextFormat = $displayTextFormat;
        return $this;
    }

    public function build(): SignatureRequest
    {
        $this->validateParameters();

        $request = new SignatureRequest();
        $request->setRelyingPartyUUID($this->getRelyingPartyUUID());
        $request->setRelyingPartyName($this->getRelyingPartyName());
        $request->setPhoneNumber($this->getPhoneNumber());
        $request->setNationalIdentityNumber($this->getNationalIdentityNumber());
        $request->setHash($this->getHashToSign()->getHashInBase64());
        $request->setHashType($this->getHashToSign()->getHashType()->getHashTypeName());
        $request->setLanguage($this->getLanguage());
        $request->setDisplayText($this->getDisplayText());
        $request->setDisplayTextFormat($this->getDisplayTextFormat());
        return $request;
    }


    private function validateParameters()
    {
        if (!isset($this->phoneNumber)) {
            throw new MissingOrInvalidParameterException("phoneNumber must be set");
        }

        if (!isset($this->nationalIdentityNumber)) {
            throw new MissingOrInvalidParameterException("nationalIdentityNumber must be set");
        }


        MidInputUtil::validateUserInput($this->phoneNumber, $this->nationalIdentityNumber);

        if (is_null($this->hashToSign)) {
            throw new MissingOrInvalidParameterException("hashToSign must be set");
        }

        if (is_null($this->language)) {
            throw new MissingOrInvalidParameterException("Language for user dialog in mobile phone must be set");
        }
    }

    private function getHashToSign(): MobileIdSignatureHashToSign
    {
        return $this->hashToSign;
    }

    private function getRelyingPartyName(): ?string
    {
        return $this->relyingPartyName;
    }

    private function getRelyingPartyUUID(): ?string
    {
        return $this->relyingPartyUUID;
    }

    private function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    private function getNationalIdentityNumber(): string
    {
        return $this->nationalIdentityNumber;
    }

    protected function getHashType(): HashType
    {
        return $this->getHashToSign()->getHashType();
    }

    protected function getHashInBase64(): string
    {
        return $this->getHashToSign()->getHashInBase64();
    }

    private function getLanguage(): Language
    {
        return $this->language;
    }

    private function getDisplayText(): ?string
    {
        return $this->displayText;
    }

    private function getDisplayTextFormat(): ?string
    {
        return $this->displayTextFormat;
    }
}
