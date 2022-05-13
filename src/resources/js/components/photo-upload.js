import React, { useEffect, useState } from 'react';
import ValidationErrors from '@/components/form/validationerrors';
import { Head, useForm } from '@inertiajs/inertia-react';
import { CameraIcon } from '@heroicons/react/solid'

export default function PhotoUpload(props) {

  const { data, setData, post, processing, errors, reset } = useForm({
    photo: null,
  });

  const [ doUpload, triggerUpload ] = useState(false);

  const triggerFileBrowser = () => {
    const input = document.getElementById('file');
    if(input && !processing) input.click();
  }

  const uploadFile = (e) => {
    setData('photo', e.target.files[0]);
    triggerUpload(true);
  }

  useEffect(() => {
    // force data to update before posting, must be a better way to do this?!
    if(data.photo != null && !processing && doUpload) {
      triggerUpload(false)
      post(props.target);
    }
  });

  return (
    <div>
      <form>
        <input
          type="file"
          id="file"
          className="hidden"
          accept="image/*"
          onChange={ (e) => uploadFile(e) }
        />
      </form>

      <div className={`w-24 mx-auto p-4 rounded-full bg-purple-800 text-center ${ processing && 'opacity-25'} cursor-pointer`}>
        <CameraIcon className="text-neutral-100" onClick={ triggerFileBrowser }/>
      </div>
      { errors && (
        <ValidationErrors errors={ errors } />
      )}
    </div>
  );

}
