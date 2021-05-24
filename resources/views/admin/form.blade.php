@extends('twill::layouts.form')

@section('contentFields')
    @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('input', [
                'name' => 'cca2',
                'label' => 'Code CCA2',
                'translated' => false,
                'maxlength' => 10
            ])
        @endslot

        @slot('right')
            @formField('input', [
                'name' => 'cca3',
                'label' => 'Code CCA3',
                'translated' => false,
                'maxlength' => 10
            ])
        @endslot
    @endcomponent

    @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('input', [
                'name' => 'latitude',
                'label' => 'Latitude',
                'translated' => false,
            ])
        @endslot

        @slot('right')
            @formField('input', [
                'name' => 'longitude',
                'label' => 'Longitude',
                'translated' => false,
            ])
        @endslot
    @endcomponent
@stop

@section('fieldsets')
    <a17-fieldset title="{{__('Cities')}}" id="cities" :open="true">
        @formField('browser', [
            'moduleName' => 'cities',
            'name' => 'cities',
            'label' => __('Cities'),
            'max' => 100,
        ])
    </a17-fieldset>

    @if(config('twill.capsule.cities.seo.enabled'))
        <a17-fieldset title="{{__('SEO')}}" id="seo" :open="false">
            @formField('input', [
                'name' => 'seo_title',
                'label' => 'SEO title',
                'translated' => false,
            ])

            @formField('input', [
                'name' => 'seo_description',
                'label' => 'SEO description',
                'translated' => false,
            ])
        <a17-fieldset title="{{__('Cities')}}" id="cities" :open="true">
    @endif
@stop
