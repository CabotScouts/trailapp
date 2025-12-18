import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import { __ } from '@/composables/translations';

export default function DeleteEvent({ event }) {

  const { data, setData, post, processing, errors, reset } = useForm({
    id: event.id,
  });

  const deleteEvent = (e) => {
    e.preventDefault();
    post(route('delete-event', event.id));
  }

  return (
    <>
      <Head title={__("Delete Event")} />
      <Modal back={route('edit-event', event.id)}>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
            <Header title={__("Delete Event")}>
              <p className="text-orange-500 font-medium mb-2">{__("delete_event_check", { event: <span className="font-bold">{event.name}</span> })}</p>
              <p className="text-red-500 font-bold">{__("delete_event_outcome")}</p>
            </Header>
            <Errors errors={errors} />
            <Group onSubmit={deleteEvent}>
              <input type="hidden" name="id" value={event.id} />
              <button type="submit" className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">{__("Delete Event")}</button>
            </Group>
          </div>
        </div>
      </Modal>
    </>
  );
}
