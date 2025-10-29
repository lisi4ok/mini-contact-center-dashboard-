import ContactController from '@/actions/App/Http/Controllers/ContactController';
import { type BreadcrumbItem } from '@/types';
import { Transition } from '@headlessui/react';
import { Form, Head,} from '@inertiajs/react';
import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { Contact } from '@/types';
import { index } from '@/routes/contacts';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Contacts',
        href: index().url,
    },
];


export default function EditContact({ contact }: { contact: Contact }) {
    console.log(contact)
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Edit Contact" />

            <div className="w-full max-w-xl px-4 py-6">

                <div className="space-y-6">
                    <HeadingSmall
                        title={"Edit Contact #" + contact.id}
                        description="Edit Contact - name, email address, phone number and company name"
                    />

                    <Form
                        {...ContactController.update.form({ contact: contact.id })}
                        options={{
                            preserveScroll: true,
                        }}
                        className="space-y-6"
                    >
                        {({ processing, recentlySuccessful, errors }) => (
                            <>
                                <div className="grid gap-2">
                                    <Label htmlFor="name">Name</Label>

                                    <Input
                                        id="name"
                                        type="text"
                                        className="mt-1 block w-full"
                                        name="name"
                                        required
                                        autoFocus
                                        tabIndex={1}
                                        placeholder="Full name"
                                        defaultValue={contact.name}
                                    />

                                    <InputError
                                        className="mt-2"
                                        message={errors.name}
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="email">Email address</Label>

                                    <Input
                                        id="email"
                                        type="email"
                                        className="mt-1 block w-full"
                                        name="email"
                                        required
                                        autoFocus
                                        tabIndex={2}
                                        placeholder="Email address"
                                        defaultValue={contact.email}
                                    />

                                    <InputError
                                        className="mt-2"
                                        message={errors.email}
                                    />
                                </div>


                                <div className="grid gap-2">
                                    <Label htmlFor="phone">Phone</Label>

                                    <Input
                                        id="phone"
                                        type="text"
                                        className="mt-1 block w-full"
                                        name="phone"
                                        required
                                        autoFocus
                                        tabIndex={3}
                                        placeholder="Phone Number"
                                        defaultValue={contact.phone}
                                    />

                                    <InputError
                                        className="mt-2"
                                        message={errors.phone}
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="company">Company</Label>

                                    <Input
                                        id="company"
                                        type="text"
                                        className="mt-1 block w-full"
                                        name="company"
                                        autoFocus
                                        tabIndex={4}
                                        placeholder="Company Name"
                                        defaultValue={contact.company}
                                    />

                                    <InputError
                                        className="mt-2"
                                        message={errors.company}
                                    />
                                </div>

                                <div className="flex items-center gap-4">
                                    <Button
                                        disabled={processing}
                                        data-test="update-button"
                                    >
                                        Update
                                    </Button>

                                    <Transition
                                        show={recentlySuccessful}
                                        enter="transition ease-in-out"
                                        enterFrom="opacity-0"
                                        leave="transition ease-in-out"
                                        leaveTo="opacity-0"
                                    >
                                        <p className="text-sm text-neutral-600">
                                            Saved
                                        </p>
                                    </Transition>
                                </div>
                            </>
                        )}
                    </Form>
                </div>
            </div>
        </AppLayout>
    );
}
