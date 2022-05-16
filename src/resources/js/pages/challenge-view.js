import React from 'react';
import { Head } from '@inertiajs/inertia-react';
import { Modal, Header } from '@/layouts/modal';
import PhotoUpload from '@/components/photo-upload';
import PhotoSubmission from '@/components/photo-submission';

export default function Challenge({ challenge, submission }) {
  return (
    <>
      <Head title={ challenge.name } />
      <Modal back={ route('trail') }>
        <Header data={ challenge } />
        <PhotoUpload target={ route('submit-challenge', challenge.id) } />
        <PhotoSubmission submission={ submission } />
      </Modal>
    </>
  );
}
