import InteractionController from '@/actions/App/Http/Controllers/InteractionController';
import { type BreadcrumbItem, Contact } from '@/types';
import { Transition } from '@headlessui/react';
import { Form, Head,} from '@inertiajs/react';
import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { create } from '@/routes/contacts';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"
import * as React from 'react';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Contact',
        href: create().url,
    },
];

export default function CreateInteraction({ contacts }: { contacts: Contact[] }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Interaction" />

            <div className="w-full max-w-xl px-4 py-6">

                <div className="space-y-6">
                    <HeadingSmall
                        title="Create Interaction"
                        description="Create Interaction - type, note contact"
                    />

                    <Form
                        {...InteractionController.store.form()}
                        options={{
                            preserveScroll: true,
                        }}
                        className="space-y-6"
                    >
                        {({ processing, recentlySuccessful, errors }) => (
                            <>
                                <div className="grid gap-2">
                                    <Label htmlFor="name">Contact</Label>
                                    {contacts.length >= 1 && (
                                        <Select name="contact_id">
                                            <SelectTrigger className="w-[180px]">
                                                <SelectValue placeholder="Select a Contact" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectLabel>Contact</SelectLabel>
                                                    {contacts.map((contact: Contact) =>
                                                        <SelectItem value={contact.id.toString()}>{contact.name}</SelectItem>
                                                    )}
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                    )}

                                    <InputError
                                        className="mt-2"
                                        message={errors.contact_id}
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="type">type</Label>

                                    <Select name="type">
                                        <SelectTrigger className="w-[180px]">
                                            <SelectValue placeholder="Select a Type" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Type</SelectLabel>
                                                <SelectItem value="click">Click</SelectItem>
                                                <SelectItem value="hover">Hover</SelectItem>
                                                <SelectItem value="scroll">Scroll</SelectItem>
                                                <SelectItem value="keyboard">Keyboard</SelectItem>
                                                <SelectItem value="swipe">Swipe</SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>

                                    <InputError
                                        className="mt-2"
                                        message={errors.type}
                                    />
                                </div>


                                <div className="grid gap-2">
                                    <Label htmlFor="note">Note</Label>

                                    <Input
                                        id="note"
                                        type="text"
                                        className="mt-1 block w-full"
                                        name="note"
                                        autoFocus
                                        tabIndex={3}
                                        placeholder="Note"
                                    />

                                    <InputError
                                        className="mt-2"
                                        message={errors.note}
                                    />
                                </div>

                                <div className="flex items-center gap-4">
                                    <Button
                                        disabled={processing}
                                        data-test="create-button"
                                    >
                                        Create
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
