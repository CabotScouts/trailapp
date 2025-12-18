import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import { __ } from '@/composables/translations';

export default function ToggleRunningEvent({ event }) {

  const { data, setData, post, processing, errors, reset } = useForm({
    id: event.id,
  });

  const toggleRunning = (e) => {
    e.preventDefault();
    post(route('toggle-event-running', event.id));
  }

  return (
    <>
      <Head title={__("Toggle Running Event")} />
      <Modal>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">

            {(event.running == true) &&
              <Header title={__("Stop Running Event")}>
                <p className="font-medium mb-2">{__("stop_event_check", { event: <span className="font-bold">{event.name}</span> })}</p>
                <p className="text-red-500">{__("stop_event_outcome")}</p>
              </Header>
            }
            {(event.running == false) &&
              <Header title={__("Start Running Event")}>
                <p className="font-medium mb-2">{__("start_event_check", { event: <span className="font-bold">{event.name}</span> })}</p>
              </Header>
            }
            <Errors errors={errors} />

            <Group onSubmit={toggleRunning}>
              <input type="hidden" name="id" value={event.id} />
              {(event.running == true) &&
                <button type="submit" className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">{__("Stop Running Event")}</button>
              }
              {(event.running == false) &&
                <button type="submit" className="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">{__("Start Running Event")}</button>
              }
            </Group>
          </div>
        </div>
      </Modal>
    </>
  );
}
