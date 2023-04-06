import React from 'react';
import { Head, useForm } from '@inertiajs/inertia-react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';

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
      <Head title="Toggle Running Event" />
      <Modal back={route('events')}>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">

            {(event.running == true) &&
              <Header title="Stop Running Event">
                <p className="font-medium mb-2">Are you sure you want to stop running <span className="font-bold">{event.name}</span>?</p>
                <p className="text-red-500">This will end the event, any teams currently participating will be locked out.</p>
              </Header>
            }
            {(event.running == false) &&
              <Header title="Start Running Event">
                <p className="font-medium mb-2">Are you sure you want to start running <span className="font-bold">{event.name}</span>?</p>
              </Header>
            }
            <Errors errors={errors} />

            <Group onSubmit={toggleRunning}>
              <input type="hidden" name="id" value={event.id} />
              {(event.running == true) &&
                <button type="submit" className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">Stop Running Event</button>
              }
              {(event.running == false) &&
                <button type="submit" className="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">Start Running Event</button>
              }
            </Group>
          </div>
        </div>
      </Modal>
    </>
  );
}
