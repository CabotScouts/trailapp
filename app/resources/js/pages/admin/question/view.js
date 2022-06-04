import React from 'react';
import { Head } from '@inertiajs/inertia-react';
import { Modal, Header } from '@/layouts/modal';

export default function Question({ question }) {
  return (
    <>
      <Head title={ question.name } />
      <Modal back={ route('questions') }>
        <Header data={ question } />
      </Modal>
    </>
  );
}
