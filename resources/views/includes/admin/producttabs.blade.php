<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a  class="nav-link {{ !Str::endsWith(url()->current(), 'attributes/edit') ? 'active' : '' }}"  aria-current="page" href="{{ route('admin.products.edit', $product) }}">Algemeen</a>
            </li>
            <li class="nav-item">
                <a  class="nav-link {{ Str::endsWith(url()->current(), 'attributes/edit') ? 'active' : '' }}"  aria-current="page" href="{{ route('admin.products.attributes.edit', $product) }}">Attributen</a>
            </li>
        </ul>
    </div>
</div>
