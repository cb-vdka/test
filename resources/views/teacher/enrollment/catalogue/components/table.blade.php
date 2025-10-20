<table class="table table-striped">
    <thead>
        <tr>
            <th class="text-center">
                <input type="checkbox" id="checkAll" class="input-checkbox" value="">
            </th>
            <th>Tên nhóm thành viên</th>
            <th>Tình trạng</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($userCatalogues) && is_object($userCatalogues))
            @foreach ($userCatalogues as $userCatalogue)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" class="input-checkbox checkBoxItem" value="{{ $userCatalogue->id }}">
                    </td>
                    <td>{{ $userCatalogue->name }}</td>
                    <td>{{ $userCatalogue->description }}</td>
                    <td class="js-switch-{{ $userCatalogue->id }}">
                        <input type="checkbox" value="{{ $userCatalogue->publish }}" class="js-switch status "
                            data-field="publish" data-model="UserCatalogue"
                            {{ $userCatalogue->publish == 2 ? 'checked' : '' }}
                            data-modelId="{{ $userCatalogue->id }}" />
                    </td>
                    <td>
                        <a href="{{ route('user.catalogue.edit', $userCatalogue->id) }}" class="btn btn-primary"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('user.catalogue.delete', $userCatalogue->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{-- <span class="text-center">
    {{ $userCatalogues->links('pagination::bootstrap-4') }}
</span> --}}
