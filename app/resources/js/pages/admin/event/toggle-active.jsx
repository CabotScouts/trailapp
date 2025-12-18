import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import { __ } from '@/composables/translations';

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
      <Head title={__("Change Active Event")} />
      <Modal back={route('events')}>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
            <Header title={__("Change Active Event")}>
              <p className="font-medium mb-2">{__("change_active_check", { event: <span className="font-bold">{event.name}</span> })}</p>
              <p className="text-red-500">{__("change_active_outcome")}</p>
            </Header>
            <Errors errors={errors} />
            <Group onSubmit={toggleActive}>
              <input type="hidden" name="id" value={event.id} />
              <button type="submit" className="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">{__("Make Active Event")}</button>
            </Group>
          </div>
        </div>
      </Modal>
    </>
  );
}
