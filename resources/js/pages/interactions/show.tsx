import InteractionController from '@/actions/App/Http/Controllers/InteractionController';
import { type BreadcrumbItem, type Contact,  type Interaction } from '@/types';
import { Transition } from '@headlessui/react';
import { Form, Head,} from '@inertiajs/react';
import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { index } from '@/routes/interactions';
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
import { useState } from 'react';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Interactions',
        href: index().url,
    },
];

export default function ShowInteraction({ contacts, interaction }: { contacts: Contact[], interaction: Interaction }) {
    const [contact, setContact] = useState(interaction.contact_id.toString());
    const [type, setType] = useState(interaction.type);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Show Interaction" />

            <div className="w-full max-w-xl px-4 py-6">

                <div className="space-y-6">
                    <HeadingSmall
                        title={"Show Interaction #" + interaction.id}
                        description="Show Interaction - type, note contact"
                    />

                    <Form
                        {...InteractionController.update.form({ interaction: interaction.id })}
                        options={{
                            preserveScroll: true,
                        }}
                        className="space-y-6"
                    >
                        {({ errors }) => (
                            <>
                                <div className="grid gap-2">
                                    <Label htmlFor="name">Contact</Label>
                                    <Select name="contact_id"
                                            disabled={true}
                                            value={contact}
                                            onValueChange={(value) => {
                                                setContact(value);
                                            }}
                                    >
                                        <SelectTrigger className="w-[180px]">
                                            <SelectValue placeholder="Select a Contact" defaultValue={interaction.contact_id} />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Contact</SelectLabel>
                                                {contacts.length && contacts.map((contact: Contact) =>
                                                    <SelectItem value={contact.id.toString()}>{contact.name}</SelectItem>
                                                )}
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>

                                    <InputError
                                        className="mt-2"
                                        message={errors.contact_id}
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="type">type</Label>
                                    <Select name="type"
                                            disabled={true}
                                            value={type}
                                            onValueChange={(value) => {
                                                setType(value);
                                            }}
                                    >
                                        <SelectTrigger className="w-[180px]">
                                            <SelectValue placeholder="Select a Type" defaultValue={interaction.type} />
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
                                        defaultValue={interaction.note}
                                        disabled={true}
                                    />

                                    <InputError
                                        className="mt-2"
                                        message={errors.note}
                                    />
                                </div>
                            </>
                        )}
                    </Form>
                </div>
            </div>
        </AppLayout>
    );
}
