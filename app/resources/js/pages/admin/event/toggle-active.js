import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';

export default function ToggleActiveEvent({ event }) {

  const { data, setData, post, processing, errors, reset } = useForm({
    id: event.id,
  });

  const toggleActive = (e) => {
    e.preventDefault();
    post(route('toggle-event-active', event.id));
  }

  return (
    <>
      <Head title="Change Active Event" />
      <Modal back={route('events')}>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
            <Header title="Change Active Event">
              <p className="font-medium mb-2">Are you sure you want to make <span className="font-bold">{event.name}</span> the active event?</p>
              <p className="text-red-500">This will end the currently running event, any teams currently participating will be locked out of the event.</p>
            </Header>
            <Errors errors={errors} />
            <Group onSubmit={toggleActive}>
              <input type="hidden" name="id" value={event.id} />
              <button type="submit" className="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">Make Active Event</button>
            </Group>
          </div>
        </div>
      </Modal>
    </>
  );
}
