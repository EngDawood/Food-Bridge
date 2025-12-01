# shadcn-Inspired Blade Components for FoodBridge

This guide shows you how to use the reusable shadcn-inspired Blade components in your FoodBridge Laravel application.

## Available Components

### 1. Button Component (`<x-button>`)

Beautiful, consistent buttons with multiple variants and sizes.

**Usage:**
```blade
<!-- Primary button -->
<x-button variant="primary">
    <i class="fa-solid fa-save mr-2"></i>Save
</x-button>

<!-- Accent button -->
<x-button variant="accent">
    <i class="fa-solid fa-plus mr-2"></i>Add donation
</x-button>

<!-- Secondary button -->
<x-button variant="secondary">Cancel</x-button>

<!-- Danger button -->
<x-button variant="danger">
    <i class="fa-solid fa-trash mr-2"></i>Delete
</x-button>

<!-- Ghost button -->
<x-button variant="ghost">Learn more</x-button>

<!-- Link button -->
<x-button variant="primary" href="/donations/create">
    Create donation
</x-button>

<!-- Different sizes -->
<x-button size="sm">Small</x-button>
<x-button size="md">Medium (default)</x-button>
<x-button size="lg">Large</x-button>

<!-- Submit button -->
<x-button type="submit" variant="primary">Submit Form</x-button>
```

**Props:**
- `variant`: `primary`, `accent`, `secondary`, `danger`, `ghost` (default: `primary`)
- `size`: `sm`, `md`, `lg` (default: `md`)
- `href`: URL for link buttons (optional)
- `type`: `button`, `submit`, `reset` (default: `button`)

---

### 2. Badge Component (`<x-badge>`)

Status badges with color-coded variants.

**Usage:**
```blade
<!-- Status badges -->
<x-badge variant="success">Delivered</x-badge>
<x-badge variant="warning">Pending</x-badge>
<x-badge variant="danger">Cancelled</x-badge>
<x-badge variant="info">Scheduled</x-badge>
<x-badge variant="default">Draft</x-badge>

<!-- Named status badges (for donation/request statuses) -->
<x-badge variant="pending">Pending</x-badge>
<x-badge variant="scheduled">Scheduled</x-badge>
<x-badge variant="delivered">Delivered</x-badge>
<x-badge variant="cancelled">Cancelled</x-badge>
```

**Props:**
- `variant`: `default`, `success`, `warning`, `danger`, `info`, `pending`, `scheduled`, `delivered`, `cancelled`

---

### 3. Card Component (`<x-card>`)

Flexible card containers with optional titles.

**Usage:**
```blade
<!-- Simple card -->
<x-card>
    <p>Card content goes here</p>
</x-card>

<!-- Card with title -->
<x-card title="Donations List">
    <p>Your donations appear here</p>
</x-card>

<!-- Card with title and subtitle -->
<x-card title="My Profile" subtitle="Manage your account settings">
    <form>...</form>
</x-card>

<!-- Gradient card -->
<x-card variant="gradient" title="Featured">
    <p>Special content</p>
</x-card>

<!-- Bordered card -->
<x-card variant="bordered">
    <p>Hoverable bordered card</p>
</x-card>
```

**Props:**
- `title`: Card title (optional)
- `subtitle`: Card subtitle (optional)
- `variant`: `default`, `gradient`, `bordered` (default: `default`)

---

### 4. Alert Component (`<x-alert>`)

Beautiful alert boxes for notifications and messages.

**Usage:**
```blade
<!-- Info alert -->
<x-alert variant="info" title="Information">
    This is an informational message.
</x-alert>

<!-- Success alert -->
<x-alert variant="success" title="Success!">
    Your donation has been created successfully.
</x-alert>

<!-- Warning alert -->
<x-alert variant="warning" title="Warning">
    Please verify your email address.
</x-alert>

<!-- Danger alert -->
<x-alert variant="danger" title="Error">
    Something went wrong. Please try again.
</x-alert>

<!-- Alert without title -->
<x-alert variant="info">
    Quick information message.
</x-alert>

<!-- Custom icon -->
<x-alert variant="info" icon="fa-solid fa-bell" title="Notification">
    You have new matches available.
</x-alert>
```

**Props:**
- `variant`: `info`, `success`, `warning`, `danger` (default: `info`)
- `title`: Alert title (optional)
- `icon`: FontAwesome icon class (optional, auto-selected based on variant)

---

### 5. Input Component (`<x-input>`)

Form input fields with labels, icons, and error handling.

**Usage:**
```blade
<!-- Basic input -->
<x-input
    label="Full Name"
    name="name"
    placeholder="Enter your name"
    required
/>

<!-- Input with icon -->
<x-input
    label="Email Address"
    icon="fa-solid fa-envelope"
    name="email"
    type="email"
    placeholder="name@example.com"
    required
/>

<!-- Input with error -->
<x-input
    label="Password"
    icon="fa-solid fa-lock"
    name="password"
    type="password"
    error="{{ $errors->first('password') }}"
/>

<!-- Input with old value (after validation) -->
<x-input
    label="Quantity"
    icon="fa-solid fa-hashtag"
    name="quantity"
    type="number"
    value="{{ old('quantity') }}"
    required
/>
```

**Props:**
- `label`: Input label text (optional)
- `icon`: FontAwesome icon class (optional)
- `error`: Error message to display (optional)
- `type`: Input type (default: `text`)
- `required`: Show required asterisk (default: `false`)
- All standard HTML input attributes are supported

---

### 6. Select Component (`<x-select>`)

Dropdown/select component with shadcn styling.

**Usage:**
```blade
<!-- Basic select with options array -->
<x-select
    label="Food Type"
    icon="fa-solid fa-utensils"
    name="food_type"
    :options="['fruits' => 'Fruits', 'vegetables' => 'Vegetables', 'grains' => 'Grains']"
    :selected="old('food_type')"
    placeholder="Select food type"
    required
/>

<!-- Select with manual options -->
<x-select
    label="Role"
    icon="fa-solid fa-user-tag"
    name="role"
    :selected="old('role')"
    placeholder="Select role"
    :error="$errors->first('role')"
    required
>
    <option value="donor">Donor</option>
    <option value="beneficiary">Beneficiary</option>
    <option value="volunteer">Volunteer</option>
</x-select>

<!-- Select with error handling -->
<x-select
    label="Status"
    name="status"
    :selected="old('status', $item->status)"
    :error="$errors->first('status')"
    required
>
    <option value="pending">Pending</option>
    <option value="completed">Completed</option>
</x-select>
```

**Props:**
- `label`: Select label text (optional)
- `icon`: FontAwesome icon class (optional)
- `name`: Form field name (required)
- `options`: Array of options [value => label] (optional, can use slot instead)
- `selected`: Currently selected value (optional)
- `placeholder`: Placeholder option text (default: "Select an option")
- `error`: Error message to display (optional)
- `required`: Show required asterisk (default: `false`)

---

### 7. Textarea Component (`<x-textarea>`)

Multi-line text input with shadcn styling.

**Usage:**
```blade
<!-- Basic textarea -->
<x-textarea
    label="Notes"
    name="note"
    rows="3"
    placeholder="Enter additional details"
/>

<!-- Textarea with icon and error -->
<x-textarea
    label="Description"
    icon="fa-solid fa-sticky-note"
    name="description"
    rows="5"
    :value="old('description')"
    placeholder="Describe your request"
    :error="$errors->first('description')"
    required
/>

<!-- Textarea with existing value -->
<x-textarea
    label="Feedback"
    icon="fa-solid fa-comment"
    name="feedback"
    rows="4"
    :value="old('feedback', $item->feedback)"
/>
```

**Props:**
- `label`: Textarea label text (optional)
- `icon`: FontAwesome icon class (optional)
- `name`: Form field name (required)
- `rows`: Number of visible text rows (default: `4`)
- `value`: Current value (optional)
- `placeholder`: Placeholder text (optional)
- `error`: Error message to display (optional)
- `required`: Show required asterisk (default: `false`)

---

### 8. Page Header Component (`<x-page-header>`)

Consistent gradient header for pages.

**Usage:**
```blade
<!-- Basic header -->
<x-page-header title="My Donations" />

<!-- Header with subtitle -->
<x-page-header
    title="My Donations"
    subtitle="Manage and track your food donations"
/>

<!-- Header with icon -->
<x-page-header
    title="Add Donation"
    subtitle="Share your surplus food with those in need"
    icon="fa-solid fa-plus"
/>

<!-- Header with action button -->
<x-page-header title="My Donations" icon="fa-solid fa-hand-holding-heart">
    <x-slot name="action">
        <x-button variant="accent" href="/donations/create">
            <i class="fa-solid fa-plus mr-2"></i>Add donation
        </x-button>
    </x-slot>
</x-page-header>
```

**Props:**
- `title`: Page title (required)
- `subtitle`: Page subtitle (optional)
- `icon`: FontAwesome icon class (optional)
- `action` slot: Action buttons or links (optional)

---

## Real-World Examples

### Example 1: Complete Form with Components

```blade
<x-page-header
    title="Add Donation"
    subtitle="Share your surplus food"
    icon="fa-solid fa-plus"
/>

<x-card title="Donation Details">
    <form method="POST" action="{{ route('donations.store') }}">
        @csrf

        <div class="grid grid-cols-2 gap-6">
            <x-input
                label="Food Type"
                icon="fa-solid fa-utensils"
                name="food_type"
                value="{{ old('food_type') }}"
                error="{{ $errors->first('food_type') }}"
                required
            />

            <x-input
                label="Quantity"
                icon="fa-solid fa-hashtag"
                name="quantity"
                type="number"
                value="{{ old('quantity') }}"
                error="{{ $errors->first('quantity') }}"
                required
            />
        </div>

        <div class="mt-6 flex gap-3">
            <x-button type="submit" variant="primary">
                <i class="fa-solid fa-save mr-2"></i>Save
            </x-button>
            <x-button variant="secondary" href="/donations">
                Cancel
            </x-button>
        </div>
    </form>
</x-card>
```

### Example 2: Dashboard with Alerts and Cards

```blade
<x-page-header
    title="Dashboard"
    subtitle="Welcome back!"
    icon="fa-solid fa-home"
/>

<x-alert variant="success" title="Success!">
    Your donation was successfully matched with a beneficiary.
</x-alert>

<div class="grid grid-cols-3 gap-6 mt-6">
    <x-card title="Total Donations" variant="bordered">
        <div class="text-3xl font-bold text-primary-800">42</div>
        <p class="text-gray-600 text-sm mt-1">All time</p>
    </x-card>

    <x-card title="Active Requests" variant="bordered">
        <div class="text-3xl font-bold text-accent-500">8</div>
        <p class="text-gray-600 text-sm mt-1">Pending matches</p>
    </x-card>

    <x-card title="Deliveries" variant="bordered">
        <div class="text-3xl font-bold text-green-600">15</div>
        <p class="text-gray-600 text-sm mt-1">Completed</p>
    </x-card>
</div>
```

### Example 3: List with Status Badges

```blade
<x-card title="Recent Donations">
    <table class="w-full">
        <thead>
            <tr>
                <th>Food Type</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donations as $donation)
            <tr>
                <td>{{ $donation->food_type }}</td>
                <td>{{ $donation->quantity }}</td>
                <td>
                    <x-badge variant="{{ $donation->status }}">
                        {{ ucfirst($donation->status) }}
                    </x-badge>
                </td>
                <td>
                    <x-button variant="ghost" size="sm" href="{{ route('donations.edit', $donation) }}">
                        <i class="fa-solid fa-edit mr-1"></i>Edit
                    </x-button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-card>
```

---

## Component Color Scheme

All components use FoodBridge's color palette:

- **Primary**: `#31487A` (YInMn Blue) - Main actions, headers
- **Accent**: `#F59E0B` (Amber) - Call-to-action buttons
- **Success**: Green tones - Positive states
- **Warning**: Yellow/Amber tones - Caution states
- **Danger**: Red tones - Destructive actions
- **Info**: Blue tones - Informational messages

---

## Best Practices

1. **Consistency**: Always use these components instead of custom markup
2. **Icons**: Use FontAwesome icons with components for visual clarity
3. **Variants**: Choose the right variant for the context (e.g., `danger` for delete actions)
4. **Accessibility**: Components include proper ARIA attributes and focus states
5. **Responsive**: All components are mobile-friendly by default

---

## Migration Guide

### Before (Old Style):
```blade
<button class="bg-primary-700 hover:bg-primary-800 text-white px-6 py-3 rounded-lg">
    Save
</button>
```

### After (With Component):
```blade
<x-button variant="primary">Save</x-button>
```

This approach:
- ✅ More readable
- ✅ Consistent styling
- ✅ Easier to maintain
- ✅ Better DX (Developer Experience)

---

## Need More Components?

You can easily create more components in `resources/views/components/`:

- `select.blade.php` - Select dropdowns
- `textarea.blade.php` - Text areas
- `checkbox.blade.php` - Checkboxes
- `radio.blade.php` - Radio buttons
- `modal.blade.php` - Modal dialogs
- `dropdown.blade.php` - Dropdown menus

Follow the same shadcn-inspired patterns and FoodBridge color scheme!
