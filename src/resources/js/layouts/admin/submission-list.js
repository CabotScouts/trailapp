import React from 'react';
import Frame from '@/layouts/admin/frame';
import PhotoSubmission from '@/components/photo-submission';

export default function List({ submissions, children }) {
  return (
    <Frame title="Submissions">
      { children &&
        <div className="p-5 bg-blue-600 text-neutral-100">
          <p className="text-lg">{ children }</p>
        </div>
      }
      { (submissions.length > 0) && submissions.map((s) =>
        <div key={ s.id } className="p-5 border border-b-blue-200">
          <p className="font-serif text-xl text-medium text-blue-800">{ s.challenge }</p>
          <p className="text-sm">{ s.team } ({ s.group })</p>
          <PhotoSubmission submission={ s.file } />
          <p className="text-xs text-bold">{ s.time }</p>
        </div>
      ) }
      { (submissions.length === 0) &&
        <div className="p-5 text-center">
          <p className="text-medium text-xl">No submissions</p>
        </div>
      }
    </Frame>
  )
}
