# Osaris UK - Navigation

## Usage

After running the migrations you will need to publish the config file with:

```bash
php artisan vendor:publish --provider="OsarisUk\Navigation\NavigationServiceProvider" --tag="config"
```


## Config

In the config you can define how many navigations you would like to set up and which views you would like them to be available to.  You can also have multiple navigations available on the same view.  The key is the view you would like the navigation to be avaliable to and the value is used to group the navigations:

```php
    'navigations' => [
        '_layouts.partials.navigation' => 'main',
        'admin._layouts.partials.navigation' => [
            'admin',
            'admin_shortcuts'
        ],
    ],
```


## Blade Implementation

Here is a simple example of a blade implementation:

```html
    @foreach($navItems as $navItem)
    	@continue($navItem->realm !== 'admin') <!-- Select only 'admin' nav items where more than one group passed to the view. -->
    	
        @if (count($navItem['children']))
            <li class="has-child">
                <a href="{{ $navItem->route ? route($navItem->route) : '' }}{{ $navItem->target }}">{{ $navItem->title }}</a>
                <div class="dropdown left-indent">
                    <ul class="dropdown-items">
                        @foreach($navItem['children'] as $child)
                            <li>
                                <a href="{{ $child->route ? route($child->route) : '' }}{{ $child->target }}">{{ $child->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
        @else
            <li>
                <a href="{{ $navItem->route ? route($navItem->route) : '' }}{{ $navItem->target }}">{{ $navItem->title }}</a>
            </li>
        @endif
    @endforeach
```
