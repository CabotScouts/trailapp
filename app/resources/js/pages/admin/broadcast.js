import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import { Head, useForm } from '@inertiajs/inertia-react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Textarea from '@/components/form/textarea';
import Button from '@/components/form/button';

export default function Broadcast(props) {

  const { data, setData, post, processing, errors } = useForm({
    message: '',
  });

  const handleChange = (event) => {
    setData(event.target.name, event.target.value);
  };

  const submit = (e) => {
    e.preventDefault();
    post(route('broadcast'));
  };

  return (
    <>
      <Head title="Broadcast" />
      <Modal>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
            <Header title="Broadcast">
              <p><span className="italic">Broadcast</span> instantly sends a message to all teams - use with care, and check your message for mistakes!</p>
            </Header>
            <Errors errors={ errors } />
            <Group onSubmit={ submit }>
              <Textarea title="Message" name="message" placeholder="Send a message to all teams" onChange={ handleChange } required />
              <Button processing={ processing }>Broadcast</Button>
            </Group>
          </div>
        </div>
      </Modal>
    </>
  );
}
