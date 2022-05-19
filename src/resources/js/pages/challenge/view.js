import React from 'react';
import { Head } from '@inertiajs/inertia-react';
import { Modal, Header } from '@/layouts/modal';
import PhotoUpload from '@/components/photo-upload';
import PhotoSubmission from '@/components/photo-submission';

export default function Challenge({ challenge, submission }) {
  return (
    <>
      <Head title={ challenge.name } />
      <Modal back={ route('trail-challenges') }>
        <Header data={ challenge } />
        
        <div className="mb-32">
          <PhotoSubmission submission={ submission } />
        </div>
        
        <div className="fixed bottom-0 h-32 w-full">
          { (submission.accepted == false) && <PhotoUpload target={ route('submit-challenge', challenge.id) } /> }
        </div>
        
      </Modal>
    </>
  );
}
