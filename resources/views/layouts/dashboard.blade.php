@include('layouts.main')

<section class="menu_bar">
        @if(Auth::user()->is_admin)
            <div class="menu_link">
                <a href="{{ route('users') }}">Users</a>
            </div>
            <div class="menu_link">
                <a href="{{ route('work-orders') }}">Work Orders</a>
            </div>
        @endif
        @if(Auth::user()->is_manager)
            <div class="menu_link">
                <a href="{{ route('users.employees') }}">Employees</a>
            </div>
            <div class="menu_link">
                <a href="{{ route('work-orders') }}">Work Orders</a>
            </div>
        @endif
        @if(Auth::user()->is_employee)
            <div class="menu_link">
                <a href="{{ route('work-orders') }}">Work Orders</a>
            </div>
        @endif
        @if(Auth::user()->is_customer)
        <div class="menu_link">
            <a href="{{ route('work-orders.create') }}">Create Work Order</a>
        </div>
        <div class="menu_link">
            <a href="{{ route('customers.work-orders') }}">Work Orders</a>
        </div>
        @endif
        <div class="menu_link">
            <a href="{{ route('logout') }}" class="btn btn-primary">Logout</a>
        </div>
</section>




