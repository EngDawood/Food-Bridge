{{-- shadcn Table Header Component --}}
<thead {{ $attributes->merge(['class' => '[&_tr]:border-b']) }}>
    {{ $slot }}
</thead>
