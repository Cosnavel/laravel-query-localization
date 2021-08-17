<?php

namespace Cosnavel\LaravelQueryLocalization\Tests;

use Cosnavel\LaravelQueryLocalization\LaravelQueryLocalization;

class LaravelQueryLocalizationTest extends TestCase
{
    /** @test */
    public function it_can_resolve_the_localization_manager()
    {
        $this->assertTrue($this->localization instanceof LaravelQueryLocalization);
    }

    /** @test */
    public function it_can_get_the_current_locale()
    {
        $this->assertEquals($this->localization->getCurrentLocale(), 'en');
    }

    /** @test */
    public function it_can_a_valid_locale()
    {
        $this->assertEquals($this->localization->getCurrentLocale(), 'en');
        $this->localization->setLocale('de');
        $this->assertEquals($this->localization->getCurrentLocale(), 'de');
    }

    /** @test */
    public function it_set_default_locale_if_a_invalid_locale_tried_to_set()
    {
        $this->assertEquals($this->localization->getCurrentLocale(), 'en');
        $this->localization->setLocale('ru');
        $this->assertEquals($this->localization->getCurrentLocale(), 'en');
    }

    /** @test */
    public function it_can_get_the_supported_locales()
    {
        $this->assertEquals($this->locales, $this->localization->getSupportedLocales());
    }

    /** @test */
    public function it_can_get_the_supported_locales_keys()
    {
        $this->assertEquals(array_keys($this->locales), $this->localization->getSupportedLanguagesKeys());
    }

    /** @test */
    public function it_can_check_if_a_locale_is_supported()
    {
        $this->assertEquals($this->localization->determineValidLanguage('en'), 'en');
        $this->assertEquals($this->localization->determineValidLanguage('de'), 'de');
        $this->assertEquals($this->localization->determineValidLanguage('deruen'), 'en');
    }
}
