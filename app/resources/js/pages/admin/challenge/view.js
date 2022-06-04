import React from 'react';
import { Head } from '@inertiajs/inertia-react';
import { Modal, Header } from '@/layouts/modal';

export default function Challenge({ challenge }) {
  return (
    <>
      <Head title={ challenge.name } />
      <Modal back={ route('challenges') }>
        <Header data={ challenge } />
      </Modal>
    </>
  );
}
