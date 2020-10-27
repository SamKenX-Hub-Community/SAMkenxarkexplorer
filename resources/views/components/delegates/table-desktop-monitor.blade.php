<div class="hidden w-full table-container md:block">
    <table>
        <thead>
            <tr>
                <th>@lang('pages.monitor.order')</th>
                <th><span class="pl-14">@lang('pages.monitor.name')</span></th>
                <th><span class="pl-14">@lang('pages.monitor.forging_at')</span></th>
                <th>@lang('pages.monitor.status')</th>
                <th width="120" class="hidden text-right lg:table-cell">@lang('pages.monitor.block_id')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($delegates as $delegate)
            @if ($delegate['is_warning'])
                <tr class="bg-theme-warning-100">
            @elseif ($delegate['is_danger'])
                <tr class="bg-theme-danger-100">
            @else
                <tr>
            @endif
                    <td>
                        <div wire:loading.class="h-4 rounded-md bg-theme-secondary-300 animate-pulse"></div>
                        <div wire:loading.class="hidden">{{ $delegate['order'] }}</div>
                    </td>
                    <td>
                        <div class="flex flex-row items-center space-x-3">
                            <div wire:loading.class="w-6 h-6 rounded-full md:w-11 md:h-11 bg-theme-secondary-300 animate-pulse"></div>
                            <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
                        </div>

                        <x-general.address :address="$delegate['wallet']->username()" />
                    </td>
                    <td>
                        <div wire:loading.class="h-4 rounded-md bg-theme-secondary-300 animate-pulse"></div>
                        <div wire:loading.class="hidden">
                            @if ($delegate['forging_at']->isPast())
                                @lang('pages.monitor.completed')
                            @else
                                {{ $delegate['forging_at']->diffForHumans() }}
                            @endif
                        </div>
                    </td>
                    <td>
                        <div wire:loading.class="h-4 rounded-md bg-theme-secondary-300 animate-pulse"></div>
                        <div wire:loading.class="hidden">
                            @if (optional($delegate['forging_at'])->isFuture())
                                <span class="font-bold text-theme-gray-500">
                                    @svg('app-status-waiting', 'w-8 h-8')
                                </span>
                            @else
                                @if ($delegate['is_success'])
                                    <span class="font-bold text-theme-success-500">
                                        @svg('app-status-done', 'w-8 h-8')
                                        @lang('pages.monitor.success')
                                    </span>
                                @endif

                                @if ($delegate['is_warning'])
                                    <span class="font-bold text-theme-warning-500">
                                        @svg('app-status-missed', 'w-8 h-8')
                                        @lang('pages.monitor.warning')
                                    </span>
                                @endif

                                @if ($delegate['is_danger'])
                                    <span class="font-bold text-theme-danger-500">
                                        @svg('app-status-undone', 'w-8 h-8')
                                        @lang('pages.monitor.danger', [$delegate['missed_count']])
                                    </span>
                                @endif
                            @endif
                        </div>
                    </td>
                    <td class="hidden text-right lg:table-cell">
                        <div wire:loading.class="h-4 rounded-md bg-theme-secondary-300 animate-pulse"></div>
                        @if($delegate['last_block'])
                            <a href="{{ route('block', $delegate['last_block']['id']) }}" class="font-semibold link" wire:loading.class="hidden">
                                <x-truncate-middle :value="$delegate['last_block']['id']" />
                            </a>
                        @else
                            <div wire:loading.class="hidden">n/a</div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>